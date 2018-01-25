# Coding Guidelines for **ProfileApp**

Date: 25th Jan 2018
Language: PHP
This document is applicable only to **ProfileApp**.

# General

## Comments
* Single line comments
```php
// This is a Single line comment 
```
* Multi line comments
```php
/**
 * This is a
 * Multi line comment
 */
```
* Doc blocks
```php
/**
 * This method sets a description.
 *
 * @param string $description A text with a maximum of 80 characters
 *
 * @return void
 */
```

## Files
* All PHP files MUST end with a single blank line.
* PHP code MUST use the long ```<?php ?> ``` tags
* The closing ```?>``` tag MUST be omitted from files containing only PHP.

## Lines
* There MUST NOT be a hard limit on line length.
* The soft limit on line length MUST be 120 characters; automated style checkers
  MUST warn but MUST NOT error at the soft limit.
* Lines SHOULD NOT be longer than 80 characters; lines longer than that SHOULD
  be split into multiple subsequent lines of no more than 80 characters each.
* There MUST NOT be trailing whitespace at the end of non-blank lines.
* Blank lines MAY be added to improve readability and to indicate related blocks
  of code.
* There MUST NOT be more than one statement per line.

## Indentations
* Code MUST use an indent of 4 spaces, and MUST NOT use tabs for indenting.

## Keywords and True/False/Null
* PHP keywords MUST be in lower case.
* The PHP constants true, false, and null MUST be in lower case.

# Namespace and Use Declarations

* When present, there MUST be one blank line after the namespace declaration.
* When present, all use declarations MUST go after the namespace declaration.
* There MUST be one use keyword per declaration.
* There MUST be one blank line after the use block.

For example:

```php
<?php
namespace Vendor\Package;

use FooClass;
use BarClass as Bar;
use OtherVendor\OtherPackage\BazClass;

// ... additional PHP code ...
```

# Classes, Properties, and Methods
The term "class" refers to all classes, interfaces, and traits.
* Class names MUST be declared in StudlyCaps.
* Class constants MUST be declared in all upper case with underscore separators.

## Extends and Implements
* The extends and implements keywords MUST be declared on the same line as the
  class name.
* The opening brace for the class MUST go on its own line; the closing brace for
  the class MUST go on the next line after the body.

For example:

```php
<?php
namespace Vendor\Package;

use FooClass;
use BarClass as Bar;
use OtherVendor\OtherPackage\BazClass;

class ClassName extends ParentClass implements \ArrayAccess, \Countable
{
    // constants, properties, methods
}
```
* Lists of implements MAY be split across multiple lines, where each subsequent
  line is indented once. When doing so, the first item in the list MUST be on
  the next line, and there MUST be only one interface per line.

For example:

```php
<?php
namespace Vendor\Package;

use FooClass;
use BarClass as Bar;
use OtherVendor\OtherPackage\BazClass;

class ClassName extends ParentClass implements
    \ArrayAccess,
    \Countable,
    \Serializable
{
    // constants, properties, methods
}
```
## Properties
* Visibility MUST be declared on all properties.
* The var keyword MUST NOT be used to declare a property.
* There MUST NOT be more than one property declared per statement.
* Property names SHOULD NOT be prefixed with a single underscore to indicate
  protected or private visibility.

A property declaration looks like the following:

```php
<?php
namespace Vendor\Package;

class ClassName
{
    public $foo = null;
}
```
## Methods
* Method names MUST be declared in camelCase.
* Visibility MUST be declared on all methods.
* Method names SHOULD NOT be prefixed with a single underscore to indicate
  protected or private visibility.
* Method names MUST NOT be declared with a space after the method name.
  The opening brace MUST go on its own line, and the closing brace MUST go on
  the next line following the body. There MUST NOT be a space after the opening
  parenthesis, and there MUST NOT be a space before the closing parenthesis.

A method declaration looks like the following. Note the placement of parentheses,
commas, spaces, and braces:

```php
<?php
namespace Vendor\Package;

class ClassName
{
    public function fooBarBaz($arg1, &$arg2, $arg3 = [])
    {
        // method body
    }
}
```

## Method Arguments
* In the argument list, there MUST NOT be a space before each comma, and there
  MUST be one space after each comma.
* Method arguments with default values MUST go at the end of the argument list.

```php
<?php
namespace Vendor\Package;

class ClassName
{
    public function foo($arg1, &$arg2, $arg3 = [])
    {
        // method body
    }
}
```
* Argument lists MAY be split across multiple lines, where each subsequent line
  is indented once. When doing so, the first item in the list MUST be on the next
  line, and there MUST be only one argument per line.
* When the argument list is split across multiple lines, the closing parenthesis
  and opening brace MUST be placed together on their own line with one space
  between them.

```php
<?php
namespace Vendor\Package;

class ClassName
{
    public function aVeryLongMethodName(
        ClassTypeHint $arg1,
        &$arg2,
        array $arg3 = []
    ) {
        // method body
    }
}
```

## abstract, final, and static
* When present, the abstract and final declarations MUST precede the visibility
  declaration.
* When present, the static declaration MUST come after the visibility
  declaration.

```php
<?php
namespace Vendor\Package;

abstract class ClassName
{
    protected static $foo;

    abstract protected function zim();

    final public static function bar()
    {
        // method body
    }
}
```

## Method and Function Calls
* When making a method or function call, there MUST NOT be a space between the
  method or function name and the opening parenthesis, there MUST NOT be a space
  after the opening parenthesis, and there MUST NOT be a space before the
  closing parenthesis. In the argument list, there MUST NOT be a space before
  each comma, and there MUST be one space after each comma.

```php
<?php
bar();
$foo->bar($arg1);
Foo::bar($arg2, $arg3);
```

* Argument lists MAY be split across multiple lines, where each subsequent line
  is indented once. When doing so, the first item in the list MUST be on the
  next line, and there MUST be only one argument per line.

```php
<?php
$foo->bar(
    $longArgument,
    $longerArgument,
    $muchLongerArgument
);
```

# Control Structures

The general style rules for control structures are as follows:

* There MUST be one space after the control structure keyword
* There MUST NOT be a space after the opening parenthesis
* There MUST NOT be a space before the closing parenthesis
* There MUST be one space between the closing parenthesis and the opening brace
* The structure body MUST be indented once
* The closing brace MUST be on the next line after the body
* The body of each structure MUST be enclosed by braces. This standardizes how
  the structures look, and reduces the likelihood of introducing errors as new
  lines get added to the body.

## if, elseif, else
An if structure looks like the following. Note the placement of parentheses,
spaces, and braces; and that else and elseif are on the same line as the closing
brace from the earlier body.

```php
<?php
if ($expr1) {
    // if body
} elseif ($expr2) {
    // elseif body
} else {
    // else body;
}
```
The keyword elseif SHOULD be used instead of else if so that all control
keywords look like single words.

## switch, case
A switch structure looks like the following. Note the placement of parentheses,
spaces, and braces. The case statement MUST be indented once from switch, and
the break keyword (or other terminating keyword) MUST be indented at the same
level as the case body. There MUST be a comment
such as // no break when fall-through is intentional in a non-empty case body.

```php
<?php
switch ($expr) {
    case 0:
        echo 'First case, with a break';
        break;
    case 1:
        echo 'Second case, which falls through';
        // no break
    case 2:
    case 3:
    case 4:
        echo 'Third case, return instead of break';
        return;
    default:
        echo 'Default case';
        break;
}
```
## while, do while
A while statement looks like the following. Note the placement of parentheses,
spaces, and braces.

```php
<?php
while ($expr) {
    // structure body
}
```
Similarly, a do while statement looks like the following. Note the placement of
parentheses, spaces, and braces.

```php
<?php
do {
    // structure body;
} while ($expr);
```

## for
A for statement looks like the following. Note the placement of parentheses,
spaces, and braces.
```php
<?php
for ($i = 0; $i < 10; $i++) {
    // for body
}
```

## foreach
A foreach statement looks like the following. Note the placement of parentheses,
spaces, and braces.
```php
<?php
foreach ($iterable as $key => $value) {
    // foreach body
}
```

## try, catch
A try catch block looks like the following. Note the placement of parentheses,
spaces, and braces.

```php
<?php
try {
    // try body
} catch (FirstExceptionType $e) {
    // catch body
} catch (OtherExceptionType $e) {
    // catch body
}
```
