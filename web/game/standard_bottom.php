  	//RESET GAME TO START
        game.resetGame();

        //START UPDATING
        var t=setInterval("game.update()",32)

        //brian - update score in database
        var t=setInterval("game.updateScore()",1000)
				
	//check if game has gone on too long
        var t=setInterval("game.checkTime()",1000)
}
);

window.onresize = function(event)
{
        mApplication.mWindow = window.getSize();
}
</script>

</body>
</html>

