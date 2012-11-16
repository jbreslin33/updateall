  	//RESET GAME TO START
        mGame.resetGame();

        //START UPDATING
        var t=setInterval("mGame.update()",32)

                //brian - update score in database
                var t=setInterval("mGame.updateScore()",1000)
				
				//check if game has gone on too long
         		var t=setInterval("mGame.checkTime()",1000)

}
);

window.onresize = function(event)
{
        mApplication.mWindow = window.getSize();
}
</script>

</body>
</html>

