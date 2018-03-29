
let scene:Phaser.Scene = new Phaser.Scene("");

let blitter = new Phaser.GameObjects.Blitter(scene, 10, 10);

let conf:GameConfig = {
    type:Phaser.AUTO,
    width: 100,
    height: 100,
    zoom: 1,
    resolution: 1
}