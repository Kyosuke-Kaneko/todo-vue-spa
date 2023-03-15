# 参考チュートリアル
https://www.hypertextcandy.com/vue-laravel-tutorial-introduction#%E9%96%A2%E9%80%A3%E8%A8%98%E4%BA%8B

# 構成
- Nginx 1.15
- MySQL 5.7
- composer latest(固定バージョンに修正予定)
- PHP 8.2
- Laravel 9.19
- Node 18.14

# 環境構築手順
## 初回ローカル環境構築
1. リポジトリをクローンする
```
git clone https://github.com/ryo-okazaki/todo-vue-spa.git
```
2. 環境を構築する
```
make install
```
3. ブラウザを確認する  
http://localhost:8080/

## 2回目以降
1. コンテナを立ち上げる
```
make up
```
