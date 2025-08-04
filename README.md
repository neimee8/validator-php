# 🚧 This project is a work in progress

While the main functionality is implemented and appears to work, the code hasn't been refactored yet, and there are no tests or documentation.
Expect bugs, especially in edge cases.

## 🛠️ Planned & Implemented

### ValidationNode

```php
ValidationNode(
    array|self|null $node = null,
    ?string $rule = null,
    ?array $params = null,
    ?ValidationMode $validation_mode = null
);
```

#### 📌 Purpose
Represents a single validation rule with its parameters.

#### 🛠️ Construction formats
You can instantiate a `ValidationNode` using:

1. Associative format:
  ```php
  new ValidationNode(
      node: [
          'rule' => 'value_in',
          'params' => [
              'haystack' => [1, 2, 3]
          ]
      ]
  );
  ```
2. Indexed format:
  ```php
  new ValidationNode(node: ['equals', [[1, 2, 3]]]);
  ```
3. Direct parameters:
  ```php
  new ValidationNode(rule: 'equals', params: [[1, 2, 3]]);
  ```
4. Validation mode
  ```php
  new ValidationNode(..., validation_mode: ValidationNode::DISALLOW_INCOMPATIBLE_VALUES);
  ```
  `validation_mode` controls behavior when the validated value is incompatible with the rule's expected type:
  * `DISALLOW_INCOMPATIBLE_VALUES` – throws an exception on incompatible types (default)
  * `ALLOW_INCOMPATIBLE_VALUES` – silently returns `false`

  These modes are available on all `ValidationAgent` subclasses.

#### ⚙️ Configuration methods
You can also configure a ValidationNode after instantiation:

```php
$node = new ValidationNode();
$node -> setNode([
    'rule' => 'value_in',
    'params' => [
        'haystack' => [1, 2, 3]
    ]
]);
$node -> setRule('value_in');
$node -> setParams(['haystack' => [1, 2, 3]]);
```

#### ✅ Validation
To validate a value:
```php
$node -> validate($value);
```
Behavior:
  * Returns `bool` by default.
  * To retrieve validation result explicitly:
  ```php
  $node -> getResult();
  ```
  * To retrieve a detailed report:
  ```php
  $node -> getReport();
  ```
  * To get a report directly from `validate()`:
  ```php
  $node -> validate($value, return_report: true);
  ```

---

### ValidationExpression

```php
ValidationExpression(
    array|self|null $expression = null,
    string $logic = 'all',
    ?array $operands = null,
    ?bool $invert = null,
    ?ValidationMode $validation_mode = null
);
```

#### 📌 Purpose
Combines multiple `ValidationNode` or `ValidationExpression` instances under a logical operator: `all`, `any`, `one`, `none`.

#### 🛠️ Construction formats
You can instantiate a `ValidationExpression` using:

1. Associative format:
  ```php
  new ValidationExpression(
      expression: [
          'logic' => 'all',
          'operands' => [
              ['rule' => 'type', 'params' => ['type' => 'string']],
              ['logic' => 'any', 'operands' => [
                  ['rule' => 'str_min_len', 'params' => ['size' => 10]],
                  ['rule' => 'str_len', 'params' => ['size' => 0]],
              ]],
          ],
          'invert' => true
      ]
  );
  ```
2. Indexed format:
  ```php
  new ValidationExpression(
      expression: [
          'all',
          [
              ['type', ['string']],
              ['any', [
                  ['str_min_len', [10]],
                  ['str_len', [0]],
              ]],
          ],
          true
      ]
  );
  ```
3. Direct parameters:
  ```php
  new ValidationExpression(
      logic: 'all',
      operands: [
          ['type', ['string']],
          ['any', [
              ['str_min_len', [10]],
              ['str_len', [0]],
          ]],
      ],
      invert: true,
      valdiation_mode: ValidationExpression::ALLOW_INCOMPATIBLE_VALUES
  );
  ```
  `invert` is optional and defaults to `false`.

  `validation_mode` behaves the same as in `ValidationNode`.

#### 🔧 Operand types
Each operand can be:
* ValidationNode (array or instance)
* ValidationExpression (array or instance)

```php
[
    'all',
    [
        new ValidationNode(['rule' => 'str_contains', 'params' => ['needle' => 'foo']])
    ]
]
```

#### ⚙️ Configuration methods
```php
$expr -> setExpression([...]);
$expr -> setLogic('any');
$expr -> setOperands([...]);
$expr -> addOperands([...]);
$expr -> addOperand(...);
$expr -> setInvertion(true);
```

#### ✅ Validation
```php
$expr -> validate($value);
```
Additional parameters:
* `return_report` (default: `false`). Returns a full report if set to `true`.
* `collect_detailed` (default: `true`). Controls whether reports from individual operands (nodes or nested expressions) are collected. If set to `false`, avoids recursive report aggregation to improve performance.
* `force_validation_mode` (default: `true`). Temporarily overrides the `validation_mode` of all nested operands for a single validation call.

---

### ValidationEntry

```php
ValidationEntry(
    array|self|null $entry = null,
    mixed $value = EmptyMarker::VALUE,
    array|ValidationNode|ValidationExpression|null $operand = null,
    ?ValidationMode $validation_mode = null
);
```

#### 📌 Purpose
Encapsulates a value with its corresponding operand (`ValidationNode` or `ValidationExpression`) and delegates validation logic accordingly.

#### 🛠️ Construction formats
You can instantiate a `ValidationEntry` using:

1. Associative format
  ```php
  new ValidationEntry(
      entry: [
          'value' => 'some string',
          'operand' => [
              'rule' => 'type',
              'params' => ['type' => 'string']
          ]
      ]
  );
  ```
2. Indexed format
  ```php
  new ValidationEntry(
      entry: [
          'some string',
          ['type', ['string']]
      ]
  );
  ```
3. Direct parameters
  ```php
  new ValidationEntry(
      value: 'some string',
      operand: ['type', ['string']],
      validation_mode: ValidationEntry::ALLOW_INCOMPATIBLE_VALUES
  );
  ```

#### 🔧 Operand types
Each operand can be:
* ValidationNode (array or instance)
* ValidationExpression (array or instance)

#### ⚙️ Configuration methods
```php
$entry -> setEntry([...])
$entry -> setValue(...);
$entry -> setOperand(...);
```

#### ✅ Validation
```php
$entry -> validate(
    return_report: false,
    collect_detailed: true,
    force_validation_mode: true
);
```

Behavior:
* Uses the `value` stored in the entry.
* Delegates validation to the associated operand.
* Supports all arguments that `ValidationExpression::validate()` supports (excluding `value`):
  * return_report
  * collect_detailed
  * force_validation_mode

---

### ValidationMap

```php
ValidationMap(
    array|self|null $map = null,
    ?ValidationMode $validation_mode = null
);
```

#### 📌 Purpose
Represents a collection of validation entries, each optionally identified by a custom key. Enables batch validation of multiple values against their corresponding validation logic.

#### 🛠️ Construction formats
You can instantiate a `ValidationMap` using:

1. Associative format (`ID` specified):
  ```php
  new ValidationMap([
      'email' => [
          'value' => 'john.doe@gmail.com',
          'operand' => ['rule' => 'str_email']
      ],
      'tags' => [
          'value' => ['a', 'b'],
          'operand' => ['rule' => 'arr_min_len', 'params' => [2]]
      ]
  ]);
  ```
2. Indexed format (`ID` omitted):
  ```php
  new ValidationMap([
      [
          'value' => 42,
          'operand' => ['rule' => 'num_positive']],
      [
          'value' => 'abc',
          'operand' => ['rule' => 'str_len', 'params' => [3]]
      ]
  ]);
  ```
  When `ID`s are omitted, entries are stored with numeric keys (`0`, `1`, `2`, ...).

  Custom `ID`s are optional and used only for reference/reporting purposes.

#### ⚙️ Configuration methods
```php
$map -> setMap([...])
$map -> addEntry(...);
$map -> clearEntry('email');
```

#### ✅ Validation
```php
$map -> validate(
    return_report: false,
    collect_detailed: true,
    force_validation_mode: true
);
```

Behavior:
* Validation is performed independently for each `ValidationEntry` in the map.
* The overall result of `validate()` is:
    * `true` only if all entries pass (logical `AND` across all entries).
    * `false` if any single entry fails.

---

### 📃 Planned
* Flexible logic modes for `ValidationMap`
    * Implement support for logical composition (`all`, `any`, `one`, `none`) similar to `ValidationExpression`
    * Allow nested logic trees inside the map structure
* Informative exception handling
* Code refactoring
* Unit testing
* Full documentation
* Generate `PHPDoc` with typed annotations for IDE autocompletion
* Composer release

## License
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

This project is licensed under the MIT License – see the [LICENSE](./LICENSE) file for details.
