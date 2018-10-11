# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Changed
- Namespace has been changed from DictTransformer to Bdt\DictTransformer
- Resources (Item, Collection, NullableItem) are now namespaced under Bdt\DictTransformer\Resources
- Resources must implement ResourceInterface
- Transformers must implement TransformerInterface
- Transformers now require a `public function getId($entity)` method (enforced at runtime, not via the interface), instead of calling `$entity->getId()`.

### Removed
- MissingKeyException has been removed, this is now enfored on the interface.

## [1.0.0] - 2018-09-19

## [0.0.2] - 2017-05-16

## [0.0.1] - 2017-05-13
