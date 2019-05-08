# Phaser 3 API Documentation

You can either:

1. Go to https://photonstorm.github.io/phaser3-docs/index.html to read the docs online. Use the drop-down menus at the top to navigate the name spaces, classes and Game Objects lists.

2. Or, you can checkout this repository and then read the documentation by pointing your browser to the local `docs/` folder. Again using the Classes and Namespaces links at the top of the page to navigate.

You can also generate new docs locally by running `npm run gen` and waiting (it may take up to an hour to generate the docs). See [Generating the Docs Locally](#generating-the-docs-locally) below for more instructions.

## TypeScript Definitions

The TypeScript defs can be found in the `typescript` folder.

They are automatically generated from the jsdoc comments in the Phaser source code. If you wish to help refine them then you must edit the Phaser jsdoc blocks directly.

**Please do not edit the defs file.**

We will not accept any PRs for the defs file itself. If you wish to help correct errors then do so in the Phaser source jsdoc blocks.

## TypeScript Defs Generation Tool

The defs generation tool is called `tsgen` and it's written in TypeScript. Build it by running `npm run build-tsgen`. This will compile the parser locally.

You can then run `npm run tsgen` to build the actual defs. Once the parser is built you only need use this command. Use it to re-generate the defs if you have modified the Phaser source code.

There is also a test script available: `npm run test-ts` which will compile a test project and output any compilation errors to `output.txt`.

## Generating the Docs Locally

Phaser uses the popular [jsdoc](http://usejsdoc.org/), which means the documentation itself is written in the source code in the [Phaser](https://github.com/photonstorm/phaser/) repository. In order to regenerate the docs, you'll need to clone that repository and it must be in a folder named `phaser` in the parent directory.

Then run `npm install` to install dependencies, and finally run `npm run gen`. The generated docs will be in a new directory called `out/`. Double click on `out/index.html` to browse the generated documentation.