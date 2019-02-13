$(document).ready(() => {
    // === GAME ===
    $(".game-panel-scores").hide();
    $(".game-panel-user").hide();
    $(".game-panel-skills").hide();
    // === LEADERBOARD ===
    $(".screen-ranking").hide();
    // === BEAUTIFUL ANIMATION OF FIRST SCREEN ===
    $(".panel").hide();
    $(".panel").children().hide();
    $(".panel").slideDown();
    setTimeout(() => $(".panel").children().slideDown(), 100);
});

var canvas = document.getElementById('game');
var ctx = canvas.getContext("2d");
var gameEng;

class Player {
    constructor(options) {
        this.images = options["images"];
        this.hp = options["hp"];
        this.state = "Idle";
        this.nickname = options["nickname"];
        this.loadImages();
        this.x = 20;
    }
    
    loadImages() {
        this.images.forEach((el, index)=>{
            let tmpImg = new Image();
            tmpImg.src = el;
            this.images[index] = tmpImg;
        });
    }

    drawImage() {
        ctx.drawImage(this.images[0], 0, 0, this.images[0].width, this.images[0].height, this.x, canvas.height-this.images[0].height/3-50, this.images[0].width/3, this.images[0].height/3);
    }
}

class Mob {
    constructor(options) {
        this.images = options["images"];
        this.hp = options["hp"];
        this.state = "Idle";
        this.name = options["name"];
    }

    loadSprites() {
        let loaded = 0;
        this.images.forEach((el) => {
            let image = new Image();
            image.src = el;
            image.onload(() => {
                loaded++;
            });
        });
    }
}

class Goblin extends Mob {
    constructor() {
        super();
    }
}

class GameEngine {
    constructor(nickname) {
        this.pause = false;
        this.player = new Player({
            hp: 100,
            nickname: nickname,
            images: ["char/knight/sprites/idle/idle0001.png"]
        });
        this.frame = 0;
        this.timestart = Date.now();
        this.timespent = 0;
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
    }
    nextStep() {
        this.frame++;
        if (this.frame == 30) {
            this.frame = 0;
            this.timespent++;
        }
        let seconds = Math.round((Date.now() - this.timestart) / 1000);
        $("div.timer").html(((Math.round(seconds / 60) >= 10) ? Math.round(seconds / 60) : "0" + Math.round(seconds / 60)) + ":" + (seconds >= 10 ? seconds : "0" + seconds));
        $("div.user-info").html(this.player.nickname);
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        gameEng.player.drawImage();
        window.requestAnimationFrame(() => this.nextStep());
    }
}

$("#preInitForm").submit((e) => {
    // === PREVENT ACTION ON BUTTON CLICK ===
    e.preventDefault();
    // === BEAUTIFUL START ANIMATION
    $(".screen-start").slideUp();
    $(".game-panel-scores").fadeIn();
    $(".game-panel-user").slideDown();
    $(".game-panel-skills").slideDown();
    // === STARTING GAME ENGINE ===
    gameEng = new GameEngine($("input[name=nickname]").val());
    gameEng.nextStep();
});

$(document).keydown((e)=>{
    switch(e.originalEvent.code){
        case "ArrowRight":
            gameEng.player.x+=5;
            break;
        case "ArrowLeft":
            gameEng.player.x-=5;
            break;
    }
});
