# quick-daily-api
## REST API

### Info
- Symfony 5

### Symfony commands:
- `php bin/console user:create EMAIL NICK PASSWORD` - create new user
- `php bin/console doctrine:schema:update --force` - aktualizacja bazy
- `php bin/console doctrine:fixtures:load` - wczytanie danych do bazy (nadpisuje wszystkie dane)
- `php bin/console doctrine:fixtures:load --append` - wczytanie danych do bazy (dodaje do istniejacych)
- `php bin/console debug:router` - wyświetla wszystkie ścieżki w aplikacji
- `php bin/console cache:clear` - czyszczenie cache
- `php bin/console cache:pool:clear cache.app` - czyszczenie cache dla cache.app pool
- `php bin/console code:generator:usecase MyUseCase` - generowanie nowego use case w strukturze Domain/Infrastructure

## Testy (komendy)
- `vendor/bin/phpunit` - uruchomienie unit testów
- `vendor/bin/phpunit --coverage-html var/cache/coverage` - generuje raport pokrycia kodu testami
- `vendor/bin/codecept run` - uruchomienie testów codeception: integracyjne/akceptacyjne 
- `vendor/bin/codecept g:cest api User` - dodanie nowego pustego testu akceptacyjnego o nazwie UserCest

## Tłumaczenia
- `php bin/console translation:update --output-format=yaml --force pl`

## TODO:
- register
- admin panel
- unit test
- github CI
- GetTeamUsers tests api
