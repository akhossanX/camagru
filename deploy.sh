
FAILURE=42

if [ -z $1 ]; then
	URL="localhost";
else
	URL=$1;
fi

echo 'Sw@rthy7akhossan' |
sudo -S nginx -t 2>config_errors;

if [ $? -ne 0 ]; then
	printf '\e[42m Configuration failure\n';
	cat config_errors;
	exit $FAILURE;
else printf "\e[32mConfiguration Success!!\n\e[0m";
fi

sudo service nginx reload;
curl $URL;
