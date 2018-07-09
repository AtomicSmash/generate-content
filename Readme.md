2# Generate Content

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

This plugin is heavily reliant on the amazing 'Faker' library.

https://github.com/fzaninotto/Faker
