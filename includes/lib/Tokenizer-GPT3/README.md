# Tokenizer-GPT3 base on PHP
> This Project is fork from [Gioni06/GPT3Tokenizer](https://github.com/Gioni06/GPT3Tokenizer)    
> Just do some changes for PHP 7.4 compatibility    

This is a PHP port of the GPT-3 tokenizer. It is based on the [original Python implementation](https://huggingface.co/docs/transformers/model_doc/gpt2#transformers.GPT2Tokenizer) and the [Nodejs implementation](https://github.com/latitudegames/GPT-3-Encoder).

GPT-2 and GPT-3 use a technique called byte pair encoding to convert text into a sequence of integers, which are then used as input for the model.
When you interact with the OpenAI API, you may find it useful to calculate the amount of tokens in a given text before sending it to the API.

If you want to learn more, read the [Summary of the tokenizers](https://huggingface.co/docs/transformers/tokenizer_summary) from Hugging Face.

## Installation
```bash
composer require ze/tokenizer-gpt3
```

## Use the configuration Class

```php
$defaultConfig = new Gpt3TokenizerConfig();

$customConfig = new Gpt3TokenizerConfig();
$customConfig
    ->vocabPath('custom_vocab.json') 
    ->mergesPath('custom_merges.txt')
    ->useCache(false)
```

### A note on caching
The tokenizer will try to use `apcu` for caching, if that is not available it will use a plain PHP `array`.
You will see slightly better performance for long texts when using the cache. The cache is enabled by default.

## Encode a text

```php
$config = new Gpt3TokenizerConfig();
$tokenizer = new Gpt3Tokenizer($config);
$text = "This is some text";
$tokens = $tokenizer->encode($text);
// [1212,318,617,2420]
```

## Decode a text
```php
$config = new Gpt3TokenizerConfig();
$tokenizer = new Gpt3Tokenizer($config);
$tokens = [1212,318,617,2420]
$text = $tokenizer->decode($tokens);
// "This is some text"
```

## Count the number of tokens in a text

```php
$config = new Gpt3TokenizerConfig();
$tokenizer = new Gpt3Tokenizer($config);
$text = "This is some text";
$numberOfTokens = $tokenizer->count($text);
// 4
```

## License
This project uses the Apache License 2.0 license. See the [LICENSE](LICENSE) file for more information.
