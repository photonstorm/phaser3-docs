@extends('app')
@section('title', 'Index')

@section('content')
@include('docs.layouts.header')
<div class="container-fluid">
    <div class="row">
        <div class="offset-0 offset-lg-1 offset-xl-2 col-12 col-lg-8 col-xl-8 order-2 order-md-1 layout-container landing-page">
            <div class="row px-2">
                <div class="col-12">
                    <div class="text-center my-4">
                        <h1 class="my-3">
                            Phaser - HTML5 Game Framework
                        </h1>
                        <img src="{{asset('images/phaser-header.png')}}" class="img-fluid" alt="Phaser Logo">
                        <div class="mt-3">
                            <a href="https://discord.gg/phaser">
                                <img src="https://img.shields.io/discord/244245946873937922?style=for-the-badge"
                                    alt="Discord chat">
                            </a>
                            <a href="https://twitter.com/phaser_">
                                <img src="https://img.shields.io/twitter/follow/phaser_?style=for-the-badge"
                                    alt="Twitter Follow">
                            </a>
                            <img src="https://img.shields.io/github/downloads/photonstorm/phaser/total?style=for-the-badge"
                                alt="GitHub All Releases">
                            <img src="https://img.shields.io/npm/dy/phaser?label=npm&amp;style=for-the-badge" alt="npm">
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <p>
                        Phaser is a fast, free, and fun open source HTML5 game framework that offers WebGL and Canvas
                        rendering
                        across desktop and mobile web browsers. Games can be compiled to iOS, Android and native apps by
                        using
                        3rd party tools. You can use JavaScript or TypeScript for development.
                    </p>
                    <p>
                        Along with the fantastic open source community, Phaser is actively developed and maintained by
                        <a href="http://www.photonstorm.com">Photon Storm</a>. As a result of rapid support, and a
                        developer
                        friendly API, Phaser is currently one of the <a
                            href="https://github.com/collections/javascript-game-engines">most starred</a> game
                        frameworks
                        on GitHub.
                    </p>
                    <p>
                        Thousands of developers from indie and multi-national digital agencies, and universities
                        worldwide
                        use Phaser. You can take a look at their incredible <a
                            href="https://phaser.io/games/">games</a>.
                    </p>
                    <p>
                        <strong>Visit:</strong> The <a href="https://phaser.io">Phaser website</a> and follow on <a
                            href="https://twitter.com/phaser_">Phaser Twitter</a>
                        <strong>Play:</strong> Some of the amazing games <a
                            href="https://twitter.com/search?q=%23madewithphaser&amp;src=typed_query&amp;f=live">#madewithphaser</a><br />
                        <strong>Learn:</strong> <a href="https://photonstorm.github.io/phaser3-docs/index.html">API
                            Docs</a>, <a href="https://phaser.discourse.group/">Support Forum</a> and <a
                            href="https://stackoverflow.com/questions/tagged/phaser-framework">StackOverflow</a><br />
                        <strong>Code:</strong> 1770+ <a href="https://phaser.io/examples">Examples</a> (source available
                        in
                        this <a href="https://github.com/photonstorm/phaser3-examples">repo</a>)<br />
                        <strong>Discord:</strong> Join us on <a
                            href="https://phaser.io/community/discord">Discord</a><br />
                        <strong>Extend:</strong> With <a href="https://phaser.io/shop/plugins">Phaser Plugins</a><br />
                        <strong>Be awesome:</strong> <a href="http://phaser.io/community/donate">Support</a> the future of Phaser<br /></p>
                    <p>Grab the source and join the fun!</p>
                    <p class="text-center">
                        <img src="https://phaser.io/images/github/div-whats-new.png" alt="What's New" title="What's New"
                            class="img-fluid">
                    </p>
                    <div class="text-center"><img src="https://phaser.io/images/github/news.jpg" class="img-fluid">
                    </div>
                    <blockquote>
                        <p>5th January 2021</p>
                    </blockquote>
                    <p>After 13 beta releases, over 200 resolved issues, thousands of lines of new code and the
                        culmination
                        of
                        over 6 months incredibly hard work, Phaser 3.50 was finally released in December 2020 and we're
                        kicking
                        off the New Year with the 3.51 point release, which addresses a few issues and throws in a
                        couple of
                        new
                        features.</p>
                    <p>It's not hyperbole or exaggeration when I say that Phaser 3.50 is the single biggest point
                        release
                        ever
                        in the history of Phaser. There are quite literally hundreds of new features to explore, updates
                        to
                        key
                        areas and of course bug fixes. I did actually try counting all the changes, but gave up after
                        I'd
                        reached 900 of them! Thankfully, they are, as always, meticulously detailed in the <a
                            href="https://github.com/photonstorm/phaser/blob/master/CHANGELOG-v3.50.md">Change Log</a>.
                        The
                        changes for 3.50 actually grew so large that I had to split them out from the main Change Log
                        and
                        put
                        them into their own file.</p>
                    <p>However, don't let this overwhelm you. A massive number of the changes are purely internal and
                        while
                        there are absolutely some API breaking changes in this release (hence the large version number
                        jump),
                        we've kept them as sensible as possible. We already know of lots of devs who have upgraded with
                        minimal,
                        or no, changes to their actual game code. We cannot guarantee that for everyone, of course, but
                        depending on how complex your game is, the chances are good.</p>
                    <p>There is plenty to be excited about in this version. It pulls together most of the R&amp;D that
                        took
                        place earlier this year for Phaser 4 and delivers it to you in version 3. New features include
                        full
                        support for post-processing effects via the new Post FX Pipeline, multi-texture support for
                        faster
                        WebGL
                        rendering, a brand new Layer Game Object for the ability to group and post process objects
                        without
                        impacting their transforms, new event hooks, a massive overhaul of the Animation system, funky
                        looking
                        new Point Lights, a new Pipeline Manager, new Camera effects, the latest version of the Spine
                        Plugin, an
                        extremely powerful new Mesh Game Object, a brand new Render Texture, huge improvements to Bitmap
                        Text,
                        isometric and hexagonal Tilemap support, a new Pushable Arcade Physics Body type, new Geometry
                        Intersection tests, Light 2D Updates and lots, lots, <strong>lots</strong> more!</p>
                    <p>As usual, I'd like to send my thanks to the Phaser community for their help in both reporting
                        issues
                        and
                        submitting pull requests to fix them. So, please do spend some time digging through the <a
                            href="#changelog">Change Log</a>. I assure you, it's worth while :)</p>
                    <p>I'd like to send a massive thank-you to everyone who supports <a
                            href="https://www.patreon.com/photonstorm">Phaser on Patreon</a>, GitHub Sponsors and our
                        corporate
                        backers. Your continued funding allows me to keep working on Phaser full-time and this monster
                        of a
                        new
                        release is the very real result of that. If you've ever considered becoming a backer, now is the
                        perfect
                        time!</p>
                    <p>If you'd like to stay abreast of developments then I'm now publishing them to the <a
                            href="https://www.patreon.com/photonstorm">Phaser Patreon</a>. Here you can find the latest
                        development reports including the concepts behind Phaser 4.</p>
                    <p>You can also follow Phaser on <a href="https://twitter.com/phaser_">Twitter</a> and chat with
                        fellow
                        Phaser devs in our <a href="https://phaser.io/community/discord">Discord</a>.</p>
                    <p>Phaser 3 wouldn't have been possible without the fantastic support of the community and Patreon.
                        Thank
                        you to everyone who supports our work, who shares our belief in the future of HTML5 gaming, and
                        Phaser's
                        role in that.</p>
                    <p>Happy coding everyone!</p>
                    <p>Cheers,</p>
                    <p>Rich - <a href="https://twitter.com/photonstorm">@photonstorm</a> <img
                            src="https://www.phaser.io/images/spacedancer.gif" alt="boogie"></p>
                    <p class="text-center"><img src="https://phaser.io/images/github/div-support-phaser.png"
                            alt="Support Phaser" title="Support Phaser" class="img-fluid"></p>
                    <p>Because Phaser is an open source project, we cannot charge for it in the same way as traditional
                        retail
                        software. What's more, we don't ever want to. After all, it's built on, and was born from, open
                        web
                        standards. It's part of our manifesto that the core framework will always be free, even if you
                        use
                        it
                        commercially, as many of you do.</p>
                    <p><strong>You may not realize it, but because of this, we rely 100% on community backing to fund
                            development.</strong></p>
                    <p>Those funds allow Phaser to improve, and when it improves, everyone involved benefits. Your
                        support
                        helps
                        secure a constant cycle of updates, fixes, new features and planning for the future.</p>
                    <p>There are other benefits to <a href="https://www.patreon.com/join/photonstorm">backing
                            Phaser</a>,
                        too:
                    </p>
                    <p class="text-center"><img src="https://phaser.io/images/github/patreon-perk-chart.png"
                            alt="Backers Perks" class="img-fluid"></p>
                    <p>We use <a href="https://www.patreon.com/photonstorm">Patreon</a> to manage the backing and you
                        can <a href="https://www.patreon.com/join/photonstorm?">support Phaser</a> from $1 per month.
                        The
                        amount
                        you pledge is entirely up to you and can be changed as often as you like. Patreon renews
                        monthly,
                        just
                        like Netflix. You can, of course, cancel at any point. Tears will be shed on this end, but
                        that's
                        not
                        your concern.</p>
                    <p>Extra special thanks to the following companies whose support makes Phaser possible:</p>
                    <ul>
                        <li><a href="https://cerebralfix.com">Cerebral Fix</a></li>
                        <li><a href="https://crossinstall.com">CrossInstall</a></li>
                        <li><a href="https://www.facebook.com">Facebook</a></li>
                        <li><a href="https://gamedistribution.com">Game Distribution</a></li>
                        <li><a href="https://www.gamecommerce.com">GameCommerce</a></li>
                        <li><a href="https://www.mozilla.org">Mozilla</a></li>
                        <li><a
                                href="https://www.codeandweb.com/texturepacker/tutorials/how-to-create-sprite-sheets-for-phaser3?utm_source=ad&amp;utm_medium=banner&amp;utm_campaign=phaser-2018-10-16">Texture
                                Packer</a></li>
                        <li><a href="https://www.twilio.com">Twilio</a></li>
                        <li><a href="https://developers.poki.com/">Poki</a></li>
                        <li><a href="https://www.crazygames.com">CrazyGames</a></li>
                        <li><a href="https://www.lagged.com">Lagged</a></li>
                        <li><a href="https://heroiclabs.com/phaserjs/">Nakama</a></li>
                    </ul>
                    <p class="text-center"><img src="https://phaser.io/images/github/sponsors-2020-12.png"
                            alt="Sponsors" class="img-fluid" title="Our Awesome Sponsors"></p>
                    <p class="text-center"><img src="https://phaser.io/images/github/div-download.png"
                            alt="Download Phaser" title="Download Phaser" class="img-fluid">
                        <a name="download"></a></p>
                    <p>Phaser 3 is available via GitHub, npm and CDNs:</p>
                    <ul>
                        <li>Clone the git repository via <a href="https://github.com/photonstorm/phaser.git">https</a>,
                            <a href="git@github.com:photonstorm/phaser.git">ssh</a> or with the GitHub <a
                                href="github-windows://openRepo/https://github.com/photonstorm/phaser">Windows</a> or <a
                                href="github-mac://openRepo/https://github.com/photonstorm/phaser">Mac</a> clients.</li>
                        <li>Download as <a href="https://github.com/photonstorm/phaser/archive/master.zip">zip</a></li>
                        <li>Download the build files: <a
                                href="https://github.com/photonstorm/phaser/releases/download/v3.51.0/phaser.js">phaser.js</a>
                            and <a
                                href="https://github.com/photonstorm/phaser/releases/download/v3.51.0/phaser.min.js">phaser.min.js</a>
                        </li>
                    </ul>
                    <h3>NPM</h3>
                    <p>Install via <a href="https://www.npmjs.com">npm</a>:</p>
                    @markdown
                    ```javascript
                    > npm install phaser
                    ```
                    @endmarkdown
                    <h3>CDN</h3>
                    <p><a href="https://www.jsdelivr.com/package/gh/photonstorm/phaser"><img
                                src="https://data.jsdelivr.com/v1/package/gh/photonstorm/phaser/badge" alt=""></a></p>
                    <p><a href="https://www.jsdelivr.com/projects/phaser">Phaser is on jsDelivr</a> which is a
                        &quot;super-fast
                        CDN for developers&quot;. Include the following in your html:</p>
                    @markdown
                    ```html
                    <script src="//cdn.jsdelivr.net/npm/phaser@3.51.0/dist/phaser.js"></script>
                    ```
                    @endmarkdown
                    <p>or the minified version:</p>
                    @markdown
                    ```html
                    <script src="//cdn.jsdelivr.net/npm/phaser@3.51.0/dist/phaser.min.js"></script>
                    ```
                    @endmarkdown
                    <h3>API Documentation</h3>
                    <p>Go to https://photonstorm.github.io/phaser3-docs/index.html to read the docs online. Use the
                        drop-down
                        menus at the top to navigate the namespaces, classes and Game Objects lists.</p>
                    <p>Or, if you wish to run the docs locally you can checkout the <a
                            href="https://github.com/photonstorm/phaser3-docs">phaser3-docs</a> repository and then read
                        the
                        documentation by pointing your browser to the <code>docs/</code> folder.</p>
                    <p>The documentation for Phaser 3 is an on-going project. Please help us by contributing improved
                        docs
                        and
                        examples.</p>
                    <h3>TypeScript Definitions</h3>
                    <p>The <a href="https://github.com/photonstorm/phaser/tree/master/types">TypeScript definitions</a>
                        can
                        be
                        found inside the <code>types</code> folder. They are also referenced in the types entry in
                        <code>package.json</code>.</p>
                    <p>Depending on your project, you may need to add the following to your <code>tsconfig.json</code>
                        file:
                    </p>

                    @markdown
                    ```javascript
                    "typeRoots": [
                    "./node_modules/phaser/types"
                    ],
                    "types": [
                    "Phaser"
                    ]
                    ```
                    @endmarkdown

                    <p>We recently published a new <a
                            href="https://github.com/photonstorm/phaser3-typescript-project-template">Phaser 3
                            TypeScript
                            Project Template</a>, which you can use to get started with if you like.</p>
                    <p>The TS defs are automatically generated from the JSDoc comments found in the Phaser source code.
                        If
                        you
                        wish to help refine them then you must edit the Phaser JSDoc blocks directly, not the defs file.
                        You
                        can
                        find more details about the parser we built in the <code>scripts/tsgen</code> folder.</p>
                    <h3>Webpack</h3>
                    <p>We use Webpack to build Phaser and we take advantage of its conditional build flag feature to
                        handle
                        renderer swapping. If you wish to use Webpack with Phaser then please use our <a
                            href="https://github.com/photonstorm/phaser3-project-template">Phaser 3 Project Template</a>
                        as
                        it's
                        already set-up to handle the build conditions Phaser needs. Recent changes to our build steps
                        mean
                        you
                        should now be able to use any other packager, like Parcel, without any config changes.</p>
                    <h3>License</h3>
                    <p>Phaser is released under the <a href="https://opensource.org/licenses/MIT">MIT License</a>.</p>
                    <p class="text-center"><img src="https://phaser.io/images/github/div-getting-started.png"
                            alt="Getting Started" title="Getting Started" class="img-fluid">
                        <a name="getting-started"></a></p>
                    <img src="https://phaser.io/images/github/learn.jpg" align="right">
                    <p>Tutorials and guides on Phaser 3 development are being published every week.</p>
                    <ul>
                        <li><a href="https://phaser.io/tutorials/getting-started-phaser3">Getting Started with Phaser
                                3</a>
                            (useful if you are completely new to Phaser)</li>
                        <li><a href="https://phaser.io/tutorials/making-your-first-phaser-3-game">Making your first
                                Phaser 3
                                Game</a></li>
                        <li>The <a href="https://academy.zenva.com/product/html5-game-phaser-mini-degree/?a=13">Complete
                                Phaser
                                3 Game Development course</a> contains over 15 hours of videos covering all kinds of
                            important
                            topics.</li>
                        <li>Plus, there are <a href="http://phaser.io/learn">over 700 Phaser tutorials</a> listed on the
                            official website.</li>
                    </ul>
                    <p>We've 3 tutorials related specifically to creating <strong>Facebook Instant Games</strong> with
                        Phaser:
                    </p>
                    <ul>
                        <li><a href="http://phaser.io/news/2018/10/facebook-instant-games-phaser-tutorial">Getting
                                Started
                                with
                                Facebook Instant Games</a></li>
                        <li><a href="http://phaser.io/news/2018/11/facebook-instant-games-leaderboards-tutorial">Facebook
                                Instant Games Leaderboards Tutorial</a></li>
                        <li><a href="http://phaser.io/news/2018/12/facebook-instant-games-ads-tutorial">Displaying Ads
                                in
                                your
                                Instant Games</a></li>
                    </ul>
                    <h3>Source Code Examples</h3>
                    <p>During our development of Phaser 3, we created hundreds of examples with the full source code and
                        assets
                        ready available. These examples are now fully integrated into the <a
                            href="https://phaser.io/examples">Phaser website</a>. You can also browse them on <a
                            href="https://labs.phaser.io">Phaser 3 Labs</a> via a more advanced interface, or clone the
                        <a href="https://github.com/photonstorm/phaser3-examples">examples repo</a>. We are constantly
                        adding
                        to and refining these examples.</p>
                    <h3>Huge list of Phaser 3 Plugins</h3>
                    <p>Super community member RexRainbow has been publishing Phaser 3 content for years, building up an
                        impressive catalogue in that time. You'll find <a
                            href="https://rexrainbow.github.io/phaser3-rex-notes/docs/site/index.html#list-of-my-plugins">loads
                            of plugins</a>, from UI controls such as text input boxes, to Firebase support, Finite State
                        Machines and lots more. As well as the plugins there is also a comprehensive set of 'Notes'
                        about
                        Phaser
                        3, going into great detail about how the various systems work. It's an invaluable resource and
                        well
                        worth checking out at <a
                            href="https://rexrainbow.github.io/phaser3-rex-notes/docs/site/index.html">https://rexrainbow.github.io</a>
                    </p>
                    <h3>Create Your First Phaser 3 Example</h3>
                    <p>Create an <code>index.html</code> page locally and paste the following code into it:</p>


                    @markdown
                    ```html
                    <!DOCTYPE html>
                    <html>

                    <head>
                        <script src="https://cdn.jsdelivr.net/npm/phaser@3.51.0/dist/phaser-arcade-physics.min.js">
                        </script>
                    </head>

                    <body>

                        <script></script>

                    </body>

                    </html>
                    ```
                    @endmarkdown


                    <p>This is a standard empty webpage. You'll notice there's a script tag that is pulling in a build
                        of
                        Phaser
                        3, but otherwise this webpage doesn't do anything yet. Now let's set-up the game config. Paste
                        the
                        following between the <code>&lt;script&gt;&lt;/script&gt;</code> tags:</p>

                    @markdown
                    ```javascript
                    var config = {
                    type: Phaser.AUTO,
                    width: 800,
                    height: 600,
                    physics: {
                    default: 'arcade',
                    arcade: {
                    gravity: { y: 200 }
                    }
                    },
                    scene: {
                    preload: preload,
                    create: create
                    }
                    };
                    ```
                    @endmarkdown
                    <p><code>config</code> is a pretty standard Phaser 3 Game Configuration object. We tell
                        <code>config</code>
                        to use the WebGL renderer if it can, set the canvas to a size of 800x600 pixels, enable Arcade
                        Physics,
                        and finally call the <code>preload</code> and <code>create</code> functions.
                        <code>preload</code>
                        and
                        <code>create</code> have not been implemented yet, so if you run this JavaScript code, you will
                        have
                        an
                        error. Add the following after <code>config</code>:</p>
                    <pre class="prettyprint source lang-javascript"><code>var game = new Phaser.Game(config);

function preload ()
{
    this.load.setBaseURL('https://labs.phaser.io');

    this.load.image('sky', 'assets/skies/space3.png');
    this.load.image('logo', 'assets/sprites/phaser3-logo.png');
    this.load.image('red', 'assets/particles/red.png');
}

function create ()
{
}
</code></pre>
                    <p><code>game</code> is a Phaser Game instance that uses our configuration object
                        <code>config</code>.
                        We
                        also add function definitions for <code>preload</code> and <code>create</code>. The
                        <code>preload</code>
                        function helps you easily load assets into your game. In <code>preload</code>, we set the Base
                        URL
                        to be
                        the Phaser server and load 3 PNG files.</p>
                    <p>The <code>create</code> function is empty, so it's time to fill it in:</p>
                    <pre class="prettyprint source lang-javascript"><code>function create ()
{
    this.add.image(400, 300, 'sky');

    var particles = this.add.particles('red');

    var emitter = particles.createEmitter({
        speed: 100,
        scale: { start: 1, end: 0 },
        blendMode: 'ADD'
    });

    var logo = this.physics.add.image(400, 100, 'logo');

    logo.setVelocity(100, 200);
    logo.setBounce(1, 1);
    logo.setCollideWorldBounds(true);

    emitter.startFollow(logo);
}
</code></pre>
                    <p>Here we add a sky image into the game and create a Particle Emitter. The <code>scale</code> value
                        means
                        that the particles will initially be large and will shrink to nothing as their lifespan
                        progresses.
                    </p>
                    <p>After creating the <code>emitter</code>, we add a logo image called <code>logo</code>. Since
                        <code>logo</code> is a Physics Image, <code>logo</code> is given a physics body by default. We
                        set
                        some
                        properties for <code>logo</code>: velocity, bounce (or restitution), and collision with the
                        world
                        bounds. These properties will make our logo bounce around the screen. Finally, we tell the
                        particle
                        emitter to follow the logo - so as the logo moves, the particles will flow from it.</p>
                    <p>Run it in your browser and you'll see the following:</p>
                    <p class="text-center"><img src="https://phaser.io/images/github/300/sample1.png"
                            alt="Phaser 3 Demo" title="Phaser 3 Demo" class="img-fluid"></p>
                    <p>(Got an error? Here's the <a
                            href="https://gist.github.com/photonstorm/46cb8fb4b19fc7717dcad514cdcec064">full code</a>)
                    </p>
                    <p>This is a tiny example, and there are hundreds more for you to explore, but hopefully it shows
                        how
                        expressive and quick Phaser is to use. With just a few easily readable lines of code, we've got
                        something pretty impressive up on screen!</p>
                    <p class="text-center"><a href="https://blog.ourcade.co"><img
                                src="https://phaser.io/images/github/ourcade.jpg" alt="Ourcade" class="img-fluid"></a>
                    </p>
                    <p>Ourcade have published <a href="https://blog.ourcade.co">two great Phaser 3 books</a>. They'll
                        take
                        you
                        from getting set-up, through to finishing your first game using modern JavaScript or TypeScript
                        and
                        they're both completely free! They also publish a huge range of quality tutorials and videos, so
                        be
                        sure
                        to check out their site every week.</p>
                    <p class="text-center"><a href="https://gumroad.com/a/244184179"><img
                                src="https://phaser.io/images/github/feronato.png"
                                alt="HTML5 Cross Platform Game Development with Phaser 3" class="img-fluid"></a></p>
                    <p>Learn the secrets of HTML5 game development with Phaser 3.50 while building a cross platform
                        endless
                        runner game. Designed both for beginners and skilled programmers, the course guides you from an
                        empty
                        folder introducing the bare bones of JavaScript to advanced Phaser 3 features. Find out more
                        details
                        about <a href="https://gumroad.com/a/244184179">HTML5 Cross Platform Game Development with
                            Phaser</a>.
                    </p>
                    <p class="text-center"><img src="https://phaser.io/images/github/div-building-phaser.png"
                            alt="Building Phaser" title="Building Phaser" class="img-fluid"></p>
                    <p>There are both plain and minified compiled versions of Phaser in the <code>dist</code> folder of
                        the
                        repository. The plain version is for use during development, and the minified version is for
                        production
                        use. You can and should also create your own builds.</p>
                    <h3>Custom Builds</h3>
                    <p>Phaser 3 is built using Webpack and we take advantage of the Webpack definePlugin feature to
                        allow
                        for
                        conditional building of the Canvas and WebGL renderers and extra plugins. You can custom the
                        build
                        process to only include the features you require. Doing so can cut the main build file size down
                        to
                        just
                        70KB.</p>
                    <p>Read our <a
                            href="https://github.com/photonstorm/phaser3-custom-build#creating-custom-phaser-3-builds">comprehensive
                            guide</a> on creating Custom Builds of Phaser 3 for full details.</p>
                    <h3>Building from Source</h3>
                    <p>If you wish to build Phaser 3 from source, ensure you have the required packages by cloning the
                        repository and then running <code>npm install</code> on your source directory.</p>
                    <p>You can then run <code>webpack</code> to create a development build in the <code>build</code>
                        folder
                        which includes source maps for local testing. You can also <code>npm run dist</code> to create a
                        minified packaged build in the <code>dist</code> folder. For a list of all commands available
                        use
                        <code>npm run help</code>.</p>
                    <p class="text-center"><img src="https://phaser.io/images/github/div-change-log.png"
                            alt="Change Log" title="Change Log" class="img-fluid">
                        <a name="changelog"></a></p>
                    <h1>Change Log</h1>
                    <p>Traditionally we have always included the most recent Change Log in this README. It was a nice
                        quick
                        way
                        for visitors to scan what's new in the latest version. However, with the 3.50.0 release we
                        cannot do
                        that because the Change Log itself is 1300 lines long and over 160KB in size.</p>
                    <p>This is somewhat unprecedented for Phaser, but then 3.50 <em>is</em> a truly massive release!</p>
                    <p>You can read the whole <a
                            href="https://github.com/photonstorm/phaser/blob/master/CHANGELOG-v3.50.md">3.51 Change Log
                            here</a>.</p>
                    <p>We've organized the Change Log into commonly themed sections to make it more digestible, but we
                        appreciate there is a lot in there. Please don't feel overwhelmed! If you need clarification
                        about
                        something, join us on the Phaser Discord and feel free to ask.</p>
                    <p>For versions prior to 3.50 you can read the previous <a
                            href="https://github.com/photonstorm/phaser/blob/master/CHANGELOG.md">Change Log</a> as
                        well.
                    </p>
                    <p class="text-center"><img src="https://phaser.io/images/github/div-contributing.png"
                            alt="Contributing" title="Contributing" class="img-fluid">
                        <a name="contributing"></a></p>
                    <p>The <a
                            href="https://github.com/photonstorm/phaser/blob/master/.github/CONTRIBUTING.md">Contributors
                            Guide</a> contains full details on how to help with Phaser development. The main points are:
                    </p>
                    <ul>
                        <li>
                            <p>Found a bug? Report it on <a href="https://github.com/photonstorm/phaser/issues">GitHub
                                    Issues</a> and include a code sample. Please state which version of Phaser you are
                                using!
                                This is vitally important.</p>
                        </li>
                        <li>
                            <p>Before submitting a Pull Request run your code through <a href="https://eslint.org/">ES
                                    Lint</a>
                                using our <a
                                    href="https://github.com/photonstorm/phaser/blob/master/.eslintrc.json">config</a>
                                and respect our <a
                                    href="https://github.com/photonstorm/phaser/blob/master/.editorconfig">Editor
                                    Config</a>.</p>
                        </li>
                        <li>
                            <p>Before contributing read the <a
                                    href="https://github.com/photonstorm/phaser/blob/master/.github/CODE_OF_CONDUCT.md">code
                                    of
                                    conduct</a>.</p>
                        </li>
                    </ul>
                    <p>Written something cool in Phaser? Please tell us about it in the <a
                            href="https://phaser.discourse.group/">forum</a>, or email support@phaser.io</p>
                    <p class="text-center"><img src="https://phaser.io/images/github/div-created-by.png"
                            alt="Created by" title="Created by" class="img-fluid"></p>
                    <div class="text-center">

                        <p>Phaser is a <a href="http://www.photonstorm.com">Photon Storm</a> production.</p>
                        <p><img src="https://www.phaser.io/images/github/photonstorm-x2.png" alt="storm"></p>
                        <p>Created by <a href="mailto:rich@photonstorm.com">Richard Davey</a>. Powered by coffee, anime,
                            pixels and
                            love.</p>
                        <p>The Phaser logo and characters are © 2020 Photon Storm Limited.</p>
                        <p>All rights reserved.</p>
                        <p>&quot;Above all, video games are meant to be just one thing: fun. Fun for everyone.&quot; -
                            Satoru Iwata
                        </p>
                    </div>
                    </article>
                    </section>
                </div>
            </div>

            <div class="clearfix"></div>


            <div class="col-md-3">
                <div id="toc" class="col-md-3 hidden-xs hidden-sm hidden-md"></div>
            </div>


        </div>
        <div class="col-12 col-lg-2 mt-4 order-1 d-flex d-md-block justify-content-center">
            <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CKYI5KQN&placement=phaserio"
                id="_carbonads_js"></script>
        </div>

    </div>
    {{-- End container --}}
</div>

@endsection
