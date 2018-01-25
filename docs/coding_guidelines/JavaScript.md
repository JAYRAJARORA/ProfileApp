# Coding Guidelines for **ProfileApp**

Date: 25th Jan 2018
Language: JavaScript
This document is applicable only to **ProfileApp**.

## Names
* Use camelCase for identifier names (variables and functions).
* Constants (like PI) should be written in UPPERCASE.
* All names should start with a letter.
```js
firstName = "John";
lastName = "Doe";

price = 19.90;
tax = 0.20;

fullPrice = price + (price * tax);
```

## Spaces Around Operators
* Always put spaces around operators ( = + - * / ), and after commas:
```js
var x = y + z;
var values = ["Volvo", "Saab", "Fiat"];
```

## Code Indentation
* Always use 4 spaces for indentation of code blocks:
```js
function toCelsius(fahrenheit) {
    return (5 / 9) * (fahrenheit - 32);
}
```

## Statement Rules
* Always end a simple statement with a semicolon.
```js
var values = ["Volvo", "Saab", "Fiat"];

var person = {
    firstName: "John",
    lastName: "Doe",
    age: 50,
    eyeColor: "blue"
};
```
* Put the opening bracket at the end of the first line.
* Use one space before the opening bracket.
* Put the closing bracket on a new line, without leading spaces.
* Do not end a complex statement with a semicolon.

**Functions**
```js
function toCelsius(fahrenheit) {
    return (5 / 9) * (fahrenheit - 32);
}
```

**Loops**
```js
for (i = 0; i < 5; i++) {
    x += i;
}
```

**Conditionals**
```js
if (time < 20) {
    greeting = "Good day";
} else {
    greeting = "Good evening";
}
```

## Object Rules
* Place the opening bracket on the same line as the object name.
* Use colon plus one space between each property and its value.
* Use quotes around string values, not around numeric values.
* Do not add a comma after the last property-value pair.
* Place the closing bracket on a new line, without leading spaces.
* Always end an object definition with a semicolon.
```js
var person = {
    firstName: "John",
    lastName: "Doe",
    age: 50,
    eyeColor: "blue"
};
```

* Short objects can be written compressed, on one line, using spaces only
  between properties, like this:
```js
var person = {firstName:"John", lastName:"Doe", age:50, eyeColor:"blue"};
```

## Line length
* Avoid lines longer than 80
```js
document.getElementById("demo").innerHTML =
    "Hello Dolly.";
```
