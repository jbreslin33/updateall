cd ..
mkdir build
cd build


mkdir breslinclient
cd breslinclient
cmake ../../breslinclient
make

cd ..
mkdir breslinlistenserver
cd breslinlistenserver
cmake ../../breslinlistenserver
make

cd ..
mkdir breslingame
cd breslingame
cmake ../../breslingame
make

cd ..
mkdir breslingameserver
cd breslingameserver
cmake ../../breslingameserver
make

cd ..
mkdir breslintalker
cd breslintalker
cmake ../../breslintalker
make

cd ..
mkdir breslinmathracer
cd breslinmathracer
cmake ../../breslinmathracer
make

cd ..
mkdir breslinmessagehandler
cd breslinmessagehandler
cmake ../../breslinmessagehandler
make

cd ..
mkdir breslinquestiongameclient
cd breslinquestiongameclient
cmake ../../breslinquestiongameclient
make

cd ..
mkdir breslinquestiongameserver
cd breslinquestiongameserver
cmake ../../breslinquestiongameserver
make

#go back to update all
cd ..
cd ..
cd updateall


