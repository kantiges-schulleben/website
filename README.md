# kantiges-schulleben
Eine wundervolle Seite für Schüler:Innen des Kantgymnasiums

[zur Website](https://www.kantiges-schulleben.de)

## API-Dokumentation v0.1

BaseUrl :  [https://kantiges-schulleben.de](https://www.kantiges-schulleben.de)/api/v0.1/

0. [Header](#header)
1. [User](#user)
    - [get](#get)
    - [create](#create)
    - [update](#update)
    - [delete](#delete)

## Header
"Authorization" : "_API-key_"

## User
Url : {BaseUrl}/user/index.php

### get

Die bei uns gespeicherten Informationen des Schülers werden abgerufen.

#### Methode: GET

| Parameter | Beschreibung          |          |
|-----------|-----------------------|----------|
| name      | Name des Schülers     | benötigt |
| password  | Passwort des Schülers | benötigt |

Beispiel:
```
{BaseUrl}/api/v0.1/user/index.php?name=immanuel.kant&password=12345
```

### create

Ein neuer Benutzer wird in unserem System angelegt, sofern keine Überschneidungen mit den Namen anderer Benutzer auftreten.

#### Methode: POST
| Parameter | Beschreibung                                                                                 |          |
|-----------|----------------------------------------------------------------------------------------------|----------|
| name      | Name des Schülers                                                                            | benötigt |
| password  | Passwort des Schülers                                                                        | benötigt |
| typ       | Angabe, ob der Schüler Nachhilfeschüler oder Nachhilfelehrer ist. (‚schueler‘ oder ‚lehrer‘) | benötigt |
| partner   | Der Lernpartner des Schülers                                                                 | benötigt |
| mail      | Emailadresse des Schülers                                                                    | optional |

Beispiel:
```json
{
    "name" : "Immanuel.Kant",
    "password" : "12345",
    "typ" : "schueler",
    "partner" : "Johann.Gottfried.Herder"
}
```

### update

Die für einen Schüler bei uns gespeicherten Daten können modifiziert werden.

#### Methode: PUT

| Parameter   | Beschreibung                                                                                 |          |
|-------------|----------------------------------------------------------------------------------------------|----------|
| name        | Name des Schülers                                                                            | benötigt |
| password    | Passwort des Schülers                                                                        | benötigt |
| newPassword | Neues Passwort des Schülers                                                                  | optional |
| typ         | Angabe, ob der Schüler Nachhilfeschüler oder Nachhilfelehrer ist. (‚schueler‘ oder ‚lehrer‘) | optional |
| partner     | Der Lernpartner des Schülers                                                                 | optional |
| mail        | Emailadresse des Schülers                                                                    | optional |

Beispiel:
```json
{
    "name" : "Immanuel.Kant",
    "password" : "12345",
    "newPassword" : "koenisberg"
}
```

### delete

Die bei uns gespeicherten Informationen des Schülers werden gelöscht.

#### Methode: DELETE

| Parameter | Beschreibung          |          |
|-----------|-----------------------|----------|
| name      | Name des Schülers     | benötigt |
| password  | Passwort des Schülers | benötigt |

Beispiel:
```json
{
    "name" : "Immanuel.Kant",
    "password" : "12345"
}
```
