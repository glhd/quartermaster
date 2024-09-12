<div style="float: right;">
	<a href="https://github.com/glhd/quartermaster/actions" target="_blank">
		<img 
			src="https://github.com/glhd/quartermaster/workflows/PHPUnit/badge.svg" 
			alt="Build Status" 
		/>
	</a>
	<a href="https://codeclimate.com/github/glhd/quartermaster/test_coverage" target="_blank">
		<img 
			src="https://api.codeclimate.com/v1/badges/45ab9ed460682eb24bb6/test_coverage" 
			alt="Coverage Status" 
		/>
	</a>
	<a href="https://packagist.org/packages/glhd/quartermaster" target="_blank">
        <img 
            src="https://poser.pugx.org/glhd/quartermaster/v/stable" 
            alt="Latest Stable Release" 
        />
	</a>
	<a href="./LICENSE" target="_blank">
        <img 
            src="https://poser.pugx.org/glhd/quartermaster/license" 
            alt="MIT Licensed" 
        />
    </a>
    <a href="https://twitter.com/inxilpro" target="_blank">
        <img 
            src="https://img.shields.io/twitter/follow/inxilpro?style=social" 
            alt="Follow @inxilpro on Twitter" 
        />
    </a>
</div>

# Quartermaster

Quartermaster makes it easy to use [PHP enums](https://www.php.net/manual/en/language.types.enumerations.php) 
with [Laravel Pennant](https://laravel.com/docs/11.x/pennant).

## Installation

```shell
composer require glhd/quartermaster
```

## Usage

Add the `EnumeratesFeatures` trait to any enum to use it with Pennant:

```php
enum BillingFeatures
{
    use EnumeratesFeatures;
    
    case NextGenerationBillingPortal;
    case LegacyBillingPortal;
    
    // Define a "resolver" for each feature:
    
    public function resolveNextGenerationBillingPortal(?Team $team)
    {
        return $team?->owner->isEnrolledInBetaFeatures();
    }
    
    public function resolveLegacyBillingPortal(?Team $team)
    {
        return $team?->created_at->lt('2022-06-01');
    }
}
```

Next, register your enum with Pennant:

```php
// in a service provider's boot method:
BillingFeatures::register();
```

Then, you can call many Pennant methods from the enum directly:

```php
if (BillingFeatures::NextGenerationBillingPortal->active()) {
    // Show next-gen billing portal
}

if (BillingFeatures::NextGenerationBillingPortal->inactive()) {
    // Show opt-in for beta features
}
```

For many checks, you may need a scope. You can use the `for()` method
on the enum to do scoped checks:

```php
if (BillingFeatures::LegacyBillingPortal->for($team)->active()) {
    // Show legacy billing portal
}

// Enable next-gen portal for team
BillingFeatures::NextGenerationBillingPortal->for($team)->activate();

// Disable next-gen portal for team
BillingFeatures::NextGenerationBillingPortal->for($team)->deactivate();

// Reset flag status for team
BillingFeatures::NextGenerationBillingPortal->for($team)->forget();
```
