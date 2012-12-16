#!/bin/bash
ls | grep DSC > /dev/null;
if [ $? == 0 ]
then
	for i in DSC*;
		do
			mv $i $(echo $i | cut -d '_' -f 2 | cut -d '.' -f 1)".jpg";
		done
fi;
echo "Striping EXIF tags...";
jhead -dc -di -dx -dt *.jpg;
echo "Generating thumbnails...";
echo "=> landscape (backgrounded)";
jhead -orl -cmd "convert &i -resize 100x67 ../photos/THUMB_&i" *.jpg &
echo "=> portrait (backgrounded)";
jhead -orp -cmd "convert &i -rotate 270 -resize 100x67 ../photos/THUMB_&i;" *.jpg &
wait;
echo "Resizing images" ;
for i in *.jpg; do
	echo "=>"$i;
	echo "  medium (backgrounded)";
	convert $i -resize 150x150 ../photos/MEDIUM_$i &
	echo "  big (backgrounded)";
	convert $i -resize 700x700 ../photos/$i &
	wait;
	#echo "  adding watermark (backgrounded)";
	#composite -dissolve 60 -gravity southeast ~/wm.png ../photos/$i ../photos/$i &
	rm $i &
	wait;
	echo "  done";
done;
echo "Ready!";
exit 0;
