# Coding Guidelines for **ProfileApp**

Date: 25th Jan 2018
Language: CSS  
This document is applicable only to **ProfileApp**.

## Structure
* Use spaces to indent each property.
* Each selector should be on its own line, ending in either a comma or an
  opening curly brace. Property-value pairs should be on their own line, with
  four spaces of indentation and an ending semicolon. The closing brace should
  be flush left, using the same level of indentation as the opening selector.
```css
#selector-1,
#selector-2,
#selector-3 {
    background: #fff;
    color: #000;
}
```

## Selectors
* For names, use lowercase and separate words with hyphens when naming
  selectors. Avoid camelcase and underscores.
* Use human readable selectors that describe what element(s) they style.
* Attribute selectors should use double quotes around values
* Refrain from using over-qualified selectors, "div.container" can simply be
  stated as ".container"
```css
#comment-form {
    margin: 1em 0;
}
 
input[type="text"] {
    line-height: 1.1;
}
```

## Properties
* Properties should be followed by a colon and a space.
* All properties and values should be lowercase, except for font names and
  vendor-specific properties.
* Use hex code for colors, or rgba() if opacity is needed. Avoid RGB format and
  uppercase, and shorten values when possible: #fff instead of #FFFFFF.
* Use shorthand (except when overriding styles) for background, border, font,
  list-style, margin, and padding values as much as possible.
```css
#selector-1 {
    background: #fff;
    display: block;
    margin: 0;
    margin-left: 20px;
}
```

## Vendor Prefixes
* Vendor prefixes should go longest (-webkit-) to shortest (unprefixed). All
  other spacing remains as per the rest of standards.
```css
.sample-output {
    -webkit-box-shadow: inset 0 0 1px 1px #eee;
    -moz-box-shadow: inset 0 0 1px 1px #eee;
    box-shadow: inset 0 0 1px 1px #eee;
}
```

## Values
* Space before the value, after the colon
* Do not pad parentheses with spaces
* Always end in a semicolon
* Use double quotes rather than single quotes, and only when needed, such as
  when a font name has a space.
* Font weights should be defined using numeric values (e.g. 400 instead of
  normal, 700 rather than bold).
* 0 values should not have units unless necessary, such as with
  transition-duration.
* Line height should also be unit-less, unless necessary to be defined as a
  specific pixel value.
* Multiple comma-separated values for one property should be separated by
  either a space or a newline, including within rgba(). Newlines should be
  used for lengthier multi-part values such as those for shorthand properties
  like box-shadow and text-shadow. Each subsequent value after the first should
  then be on a new line, indented to the same level as the selector and then
  spaced over to left-align with the previous value.
```css
.class { /* Correct usage of quotes */
    background-image: url(images/bg.png);
    font-family: "Helvetica Neue", sans-serif;
    font-weight: 700;
}
 
.class { /* Correct usage of zero values */
    font-family: Georgia, serif;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.5),
                       0 1px 0 #fff;
}
```

## Media Queries
* It is generally advisable to keep media queries grouped by media at the
  bottom of the stylesheet.
* Rule sets for media queries should be indented one level in.
```css
@media all and (max-width: 699px) and (min-width: 520px) {
 
        /* Your selectors */
}
```
