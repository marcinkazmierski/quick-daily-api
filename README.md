# quick-daily-api
## REST API

### Info
- Symfony 5

### Symfony commands:
- `php bin/console doctrine:generate:entity` - dodatnie nowej encji
- `php bin/console doctrine:schema:update --force` - aktualizacja bazy
- `php bin/console doctrine:fixtures:load` - wczytanie danych do bazy (nadpisuje wszystkie dane)
- `php bin/console doctrine:fixtures:load --append` - wczytanie danych do bazy (dodaje do istniejacych)
- `php bin/console debug:router` - wyświetla wszystkie ścieżki w aplikacji
- `php bin/console cache:clear` - czyszczenie cache
- `php bin/console cache:pool:clear cache.app` - czyszczenie cache dla cache.app pool
- `php bin/console code:generator:usecase MyUseCase` - generowanie nowego use case w strukturze Domain/Infrastructure


## TODO:
- REST API,
- unit tests
- codeception tests
