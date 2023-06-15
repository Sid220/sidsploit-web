[Main](https://github.com/Sid220/sidsploit)
# Sidsploit Web
Sidsploit Web is the web interface and API for SidSploit. It is written in plain PHP.

[//]: # (NEW!: A public instance is available at [https://sidsploit.plios.tech]&#40;https://sidsploit.plios.tech&#41;.)

## Install
### Requirements
- PHP 7.0+
- MariaDB
- Webserver
### Steps
1. Clone this repository
2. Create a database named `sidsploit` and import `src/install/sidsploit.sql`
3. Edit `src/conf/conf.php` to your database settings
4. Move `src` to the directory you wish to sidsploit from

## API Usage
### `GET /api/get_in.php`
Gets web STDIN for an exploit.
#### Parameters
- `id`: Exploit ID
#### Response
- Success
  - `[STDIN]`
  - Plain text
- Error
  - `{"error": "[ERROR MESSAGE]"}`
  - JSON

### `GET /api/get_out.php`
Gets STDOUT for an exploit.
#### Parameters
- `id`: Exploit ID
#### Response
- Success
    - `[STDOUT]`
    - Plain text
- Error
    - `{"error": "[ERROR MESSAGE]"}`
    - JSON

### `POST /api/post_in.php`
Concats param `input` to `stdin` in database
#### Parameters
- `id`: Exploit ID
- `input`: Input to concat
#### Response
- Success
    - `{"success": "OK"}`
    - JSON
- Error
    - `{"error": "[ERROR MESSAGE]"}`
    - JSON

### `POST /api/post_out.php`
Concats param `output` to `output` in database
#### Parameters
- `id`: Exploit ID
- `output`: Output to concat
#### Response
- Success
    - `{"success": "OK"}`
    - JSON
- Error
    - `{"error": "[ERROR MESSAGE]"}`
    - JSON
