# Readme template
TODO: Edit these badges to reflect your project and remove this TODO.

[![pipeline status](https://gitlab.digitalnatives.nl/digital-natives/craft3-boilerplate/badges/master/pipeline.svg)](https://gitlab.digitalnatives.nl/digital-natives/craft3-boilerplate/commits/master)
[![coverage report](https://gitlab.digitalnatives.nl/digital-natives/craft3-boilerplate/badges/master/coverage.svg)](https://gitlab.digitalnatives.nl/digital-natives/craft3-boilerplate/commits/master)

This is a headless boilerplate for building an Craft CMS with a GraphQL-powered API for any type of frontend to consume.
[ADD YOUR PROJECT DESCRIPTION HERE]

**Confluence files**
More information about this project can be found in Confluence.
[ADD YOUR CONFLUENCE PAGES HERE]

**General Information**
- [Craft docs](https://docs.craftcms.com/v3)
- [GraphQL](https://graphql.org/learn/)

## Environments

| Stage       | Branch       | Url                                      | Notes                                                  |
|-------------|--------------|------------------------------------------|--------------------------------------------------------|
| Staging     | staging      | viola-craft.ceres.digitalnatives.nl      | Staging Server                                         |
| Production  | master + tag | https://www.viola-craft.nl/              | Production Server                                      |

## Tech/framework
* Craft CMS 3.3

## Requirements
* Docker
* Craft PRO license for production

## Installation
1. Run `ezdev up`
	1. (optional) Add a record `'127.0.0.1 viola-craft.test'` to your hosts-file
2. Run `ezdev cli php bash`
3. In your docker container, run `cd craft && cp .env.example .env`
3. In your docker container, run `php composer.phar install`
4. In your docker container, run `./craft setup/welcome`
5. You should now be able to run the craft installer by navigating to 'https://viola-craft.test/admin', or run `./craft setup` in your docker container
6. Sync your project config `./craft project-config/sync`

## GraphQL
This project uses the default GraphQL implementation that ships with Craft 3.3+. Please refer to the [GraphQL documentation](https://docs.craftcms.com/v3/graphql.html) at the craftcms site for more info.
 
 
## API docs
Hi There! This project uses graphQL, so you can use your favourite documentation explorer  like [GraphQL playground](https://github.com/prisma-labs/graphql-playground) to find out what data is available.

The graphQL endpoint is `/graphql`.
