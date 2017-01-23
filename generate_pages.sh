rm ../caroltc.github.io/* -rf
cp ./Public/statics/* ../caroltc.github.io/ -R
cd ../caroltc.github.io/
git add --all
git commit -m "publish"
git push origin master
