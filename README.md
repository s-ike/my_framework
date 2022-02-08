# my_framework
PHP5.3以上で動作するwebフレームワークです

## Usage
1. Composer

- ダウンロード
https://getcomposer.org/download/
- ライブラリインストール
`$ php composer.phar install`

2. Docker
- Dockerイメージ作成
`$ docker build -t php-5.4-apache . `
- Docker run
`$ docker run --rm -p 8080:80 -v ${PWD}:/var/www/html -d php-5.4-apache`

3. アクセス
- ブラウザで`localhost:8080`へアクセス
