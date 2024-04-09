# Event sourcing

## Set up

```
docker compose up -d
docker compose run web composer install
sudo chmod -R 777 data
```

Navigeer naar http://localhost:8080/offerte/init

## Assesment

Elke gewenste refactoring die je wilt maken op de code is toegestaan

 - Implementeer alle events in EventSourcedOfferteRepository

### Optioneel

 - Implementeer een snapshot mechanisme
 - Implementeer een projectie die per producttype bij houdt hoeveel deze per maand zou opleveren.
Zie hiervoor ook http://localhost:8080/product/rapportage