<?php

declare(strict_types=1);

namespace Common\Service;

use Common\Container\ConfigInterface;
use EventBus\Event\EventSerializer;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class EventBusService implements EventBusInterface
{
    public function __construct(
        private readonly ConfigInterface $config,
        private readonly LoggerInterface $logger
    ) {
    }

    public function produce(string $message, array $headers = null): int
    {
        $producer = $this->createProducer();

        $code = RD_KAFKA_RESP_ERR_UNKNOWN;
        $topic = $producer->newTopic($this->config->get('eventbus.kafka.topic'));
        $topic->producev(RD_KAFKA_PARTITION_UA, 0, $message, 'event', $headers ?? null);
        $producer->poll(0);

        for ($attempts = 0; $attempts < $this->config->get('eventbus.kafka.producer.attempts'); $attempts++) {
            $code = $producer->flush(1000);
            if (RD_KAFKA_RESP_ERR_NO_ERROR === $code) {
                break;
            }
        }

        if (RD_KAFKA_RESP_ERR_NO_ERROR !== $code) {
            $this->logger->log(LogLevel::CRITICAL, 'Can not flush message to kafka', ['code' => $code]);
        }

        return $code;
    }

    public function consume(callable $process)
    {
        $consumer = $this->createConsumer();
        while (true) {
            $message = $consumer->consume(120 * 1000);
            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    if ($message->key == 'event') {
                        $event = (new EventSerializer())->unserialize($message->payload);
                        if (isset($message->headers['X-Request-Id'])) {
                            $event->setRequestId($message->headers['X-Request-Id']);
                        }
                        $process($event);
                    }
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    echo "No more messages; will wait for more\n";
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    echo "Timed out\n";
                    break;
                default:
                    throw new \Exception($message->errstr(), $message->err);
            }
        }
    }

    protected function createConsumer(): \RdKafka\KafkaConsumer
    {
        $kafkaConfig = new \RdKafka\Conf();
        foreach ($this->config->get('eventbus.kafka.consumer.config') as $configKey => $configValue) {
            $kafkaConfig->set($configKey, $configValue);
        }

        $consumer = new \RdKafka\KafkaConsumer($kafkaConfig);
        $consumer->subscribe([$this->config->get('eventbus.kafka.topic')]);

        return $consumer;
    }

    protected function createProducer(): \RdKafka\Producer
    {
        $kafkaConfig = new \RdKafka\Conf();
        foreach ($this->config->get('eventbus.kafka.producer.config') as $configKey => $configValue) {
            $kafkaConfig->set($configKey, $configValue);
        }

        $producer = new \RdKafka\Producer($kafkaConfig);
        $producer->addBrokers($this->config->get('eventbus.kafka.broker'));

        return $producer;
    }
}
