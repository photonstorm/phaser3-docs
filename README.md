# Phaser 3 API Documentation

The official Phaser API Documentation can be found at [https://newdocs.phaser.io](https://newdocs.phaser.io)

This repository contains a few utility files, such as JSON/JSDoc to SQL conversion scripts, that we use. But the actual docs themselves should be accessed from the URL above.

## Apple Silicon notes

```bash
 npm uninstall sqlite3
 sudo npm install sqlite3 --build-from-source --target_arch=arm64 --fallback-to-build
 ncu -u
 sudo npm i
 npm run sqlrich
 ```
 