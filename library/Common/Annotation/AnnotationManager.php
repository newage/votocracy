<?php

declare(strict_types=1);

namespace Common\Annotation;

use Common\Annotation\Hydrator\ReflectionStrategy;
use Common\Annotation\Input\Filter\AttributeFilterInterface;
use Common\Annotation\Input\Validator\AttributeValidatorInterface;
use Common\Annotation\Input\Validator\NestedEntity;
use Common\Annotation\InputFilter as AttributeInputFilter;
use Common\Exception\CriticalException;
use Common\Validator\NestedValidator;
use Laminas\Cache\Exception\ExceptionInterface;
use Laminas\Cache\Storage;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\NamingStrategy\UnderscoreNamingStrategy;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\InputFilter\InputInterface;
use Laminas\Validator\Db\AbstractDb;

final class AnnotationManager
{
    private ?HydratorInterface $hydrator = null;
    private ?InputFilterInterface $inputFilter = null;

    public function __construct(private readonly string $entityName, private readonly AdapterInterface $adapter, bool $caching = true)
    {
        if ($caching === true)
            $this->cache();
        else
            $this->parseEntity($this->entityName);
    }

    /**
     * @throws \ReflectionException
     * @throws ExceptionInterface
     */
    private function cache(): void
    {
        $cacheAdapter = new Storage\Adapter\Filesystem(['cache_dir' => 'data/cache', 'namespace' => 'annotation']);
        $cacheAdapter->addPlugin(new Storage\Plugin\Serializer());

        $reflectionClass = new \ReflectionClass($this->entityName);
        $time = filemtime($reflectionClass->getFileName());
        $tags = $cacheAdapter->getTags($reflectionClass->getShortName());

        if (isset($tags[0]) && $tags[0] == $time) {
            [$hydrator, $inputFilter] = $cacheAdapter->getItem($reflectionClass->getShortName());
            if ($hydrator instanceof HydratorInterface) {
                $this->hydrator = $hydrator;
            }
            if ($inputFilter instanceof InputFilterInterface) {
                $this->inputFilter = $inputFilter;
            }
        } else {
            $this->parseEntity($this->entityName);
            if (isset($tags[1]) && $tags[1] == $reflectionClass->getShortName()) {
                $cacheAdapter->replaceItem(
                    $reflectionClass->getShortName(),
                    [$this->getHydrator(), $this->getInputFilter()]
                );
            } else {
                $cacheAdapter->setItem(
                    $reflectionClass->getShortName(),
                    [$this->getHydrator(), $this->getInputFilter()]
                );
            }
            $cacheAdapter->setTags($reflectionClass->getShortName(), [$time, $reflectionClass->getShortName()]);
        }
    }

    public function adapter(): AdapterInterface
    {
        return $this->adapter;
    }

    public function getHydrator(): HydratorInterface
    {
        return $this->hydrator;
    }

    public function getInputFilter(): InputFilterInterface
    {
        foreach ($this->inputFilter->getInputs() as $inputFilter) {
            if ($inputFilter instanceof Input) {
                foreach ($inputFilter->getValidatorChain() as $validator) {
                    if ($validator['instance'] instanceof AbstractDb) {
                        $validator['instance']->setAdapter($this->adapter);
                    }
                }
            }
        }
        return $this->inputFilter;
    }

    protected function parseEntity(string $entityName): void
    {
        $reflectionClass = new \ReflectionClass($entityName);

        foreach ($reflectionClass->getAttributes() as $attributeName) {
            $attribute = $attributeName->newInstance();
            if ($attribute instanceof Hydrator) {
                $this->hydrator = $attribute->getHydrator();
            }
        }

        if (!$this->hydrator) {
            throw CriticalException::entityHydrator(
                'Undefined hydrator for entity',
                ['entity' => $this->entityName]
            );
        }

        $this->inputFilter = new InputFilter();

        foreach ($reflectionClass->getProperties() as $property) {
            $field = null;
            foreach ($property->getAttributes() as $attributeName) {
                $instance = $attributeName->newInstance();
                $namingStrategy = new UnderscoreNamingStrategy();
                $filteredPropertyName = $namingStrategy->extract($property->getName());

                if ($instance instanceof ReflectionStrategy) {
                    $nestedReader = new AnnotationManager($instance->getReflectionEntity(), $this->adapter);
                    $instance->setReflectionHydrator($nestedReader->getHydrator());
                }

                if ($instance instanceof Hydrator\StrategyInterface) {
                    $this->hydrator->addStrategy($property->getName(), $instance->getStrategy());
                }

                if ($instance instanceof AttributeInputFilterInterface) {
                    if ($instance instanceof AttributeInputFilter) {
                        $field = new Input($filteredPropertyName);
                        $field->setRequired($instance->isRequired());
                        $field->setAllowEmpty($instance->isAllowEmpty());
                        $field->setBreakOnFailure($instance->isBreakOnFailure());
                    }

                    if (!$field instanceof InputInterface) {
                        $field = new Input($filteredPropertyName);
                    }

                    if ($instance instanceof AttributeFilterInterface) {
                        $field->getFilterChain()->attach($instance->getFilter());
                    } elseif ($instance instanceof AttributeValidatorInterface) {
                        $validator = $instance->getValidator();
                        if ($validator instanceof NestedValidator && $instance instanceof NestedEntity) {
                            $nestedReader = new AnnotationManager($instance->getNestedClass(), $this->adapter);
                            $validator->setInputFilter($nestedReader->getInputFilter());
                        }
                        $field->getValidatorChain()->attach($validator);
                    }
                }
            }
            if ($field instanceof InputInterface) {
                $this->inputFilter->add($field);
            }
        }
    }
}
