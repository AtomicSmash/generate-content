# Generate Fake Content

This plugin generates fake content for ACF Flexible content fields.

## Usage

Generate runs **completely** on the WP-CLI, so there is no admin interface.

#### Arguments:

[post_type] - A currently existing CPT inside Wordpress

[number of posts] - Number of posts generate per run

A typical command would look like this:

```
 wp generate posts post
```

## How does it work?

This plugin is heavily reliant on the amazing 'Faker' library by Francois Zaninotto.

https://github.com/fzaninotto/Faker

## Which ACF fields are supported?

This is a breakdown of the current supported fields

### Basic
- [x] Text
- [x] Text Area
- [x] Number
- [x] Range
- [x] Email
- [x] Url
- [x] Password

### Content
- [ ] Image
- [ ] File
- [ ] Wysiwyg Editor
- [ ] oEmbed
- [ ] Gallery

### Choice
- [x] Select
- [x] Checkbox
- [x] Radio Button
- [ ] Button Group
- [ ] True / False

### Relational
- [ ] Link
- [ ] Post Object
- [ ] Page Link
- [ ] Relationship
- [ ] Taxonomy
- [ ] User

### Javascript
- [ ] Google Map
- [ ] Date Picker
- [ ] Date Time Picker
- [ ] Time Picker
- [ ] Color Picker

### Layout
- [ ] Message
- [ ] Accordion
- [ ] Tab
- [ ] Group
- [ ] Repeater
- [ ] Flexible Content
- [ ] Clone
