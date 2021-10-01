const fs = require('fs-extra');
const SQLite3 = require('better-sqlite3');

function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

var cleanName = function (name) {
    //  jsdoc format: Phaser.Scenes.Events#event:BOOT
    return name.replace('#event:', '.').replace('#', '.');
}

var createInsertQuery = function (block) {
  //  Ignore private: "access": "private"
  if (
    block.longname === "module.exports" ||
    (block.scope === "global" && block.longname === block.name) ||
    (block.hasOwnProperty("access") && block.access === "private") ||
    (block.kind === "class" && block.name === "Class")
  ) {
    return;
  }

  if ((block.kind === "function" || block.kind === "member") && block.inherited) {
    // ignore inherited
    return;
  }

  if (block.kind === "member" && block.meta.filename === 'Light.js') {
    // fix duplicate entries
    return;
  }

  var name = escape(cleanName(block.longname));
  var filenameParts = block.longname.split("#");

  if (block.kind === "constant") {
    const i = block.longname.lastIndexOf(".");
    filenameParts = [
      block.longname.substring(0, i),
      block.longname.substring(i),
    ];
  }

  var filename = filenameParts[0] + ".html";
  if (filenameParts[1]) {
    filename += "#" + filenameParts[1];
  }
  var query = `INSERT INTO searchIndex (name, type, path) VALUES ('${name}', '${capitalize(
    block.kind
  )}', '${filename}');`;
  // console.log(query);
  return query;
};

var processDocs = function (data, db) {
  var queries = [];

  for (var i = 0; i < data.docs.length; i++) {
    var block = data.docs[i];

    if (block.ignore) {
      continue;
    }

    switch (block.kind) {
      case "class":
      case "event":
      case "function":
      case "constant":
      case "namespace":
      case "member":
        const query = createInsertQuery(block);
        if (query) {
          queries.push(query)
        }
        break;
    }
  }

  console.log('Processing Queries: ', queries.length);

  queries.forEach((q) => {
    // console.log(q);
    db.exec(q);
  });
};

fs.rmdirSync('./outdash', { force: true, recursive: true });
var dir = './outdash/Phaser.docset/Contents/Resources/';
fs.mkdirSync(dir, { recursive: true });

fs.copySync('./resources/docset-icon.png', './outdash/Phaser.docset/icon.png');

fs.copySync('./docs', './outdash/Phaser.docset/Contents/Resources/Documents')
fs.unlinkSync('./outdash/Phaser.docset/Contents/Resources/Documents/quicksearch.html')

fs.writeFileSync('./outdash/Phaser.docset/Contents/Info.plist', `<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
	<key>CFBundleIdentifier</key><string>phaser</string>
	<key>CFBundleName</key><string>Phaser</string>
	<key>DocSetPlatformFamily</key><string>Phaser</string>
	<key>isDashDocset</key><true/>
  <key>dashIndexFilePath</key><string>index.html</string>
</dict>
</plist>`)

var db = new SQLite3('./outdash/docSet.db');

db.exec(`
    BEGIN TRANSACTION;
    CREATE TABLE searchIndex(id INTEGER PRIMARY KEY, name TEXT, type TEXT, path TEXT);
    CREATE UNIQUE INDEX anchor ON searchIndex (name, type, path);
    COMMIT;
`);

var data = fs.readJsonSync('./json/phaser.json');

processDocs(data, db);

fs.copySync('./outdash/docSet.db', './outdash/Phaser.docset/Contents/Resources/docSet.dsidx')
