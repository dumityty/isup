HOSTS="ns1.server.com ns2.server.com"
HOSTS="123.123.1.1 ns1.server.com"
HOSTS="www.zoocha.com www.glamworshipaaaaa.com"
SUBJECT="Host Down"

ping_attempts=3
down_hosts=down_hosts.txt

for myHost in $HOSTS
do
        count=$(ping -c $ping_attempts $myHost | awk -F, '/received/{print $2*1}')
        echo $count
        if [ $count -eq 0 ]; then
                echo "$myHost is down"
                if  [ $(grep -c "$myHost" "$down_hosts") -eq 0 ]; then
                        echo "Host : $myHost is down (ping failed) at $(date)"
                        echo "$myHost" >> $down_hosts
                fi
        else
                echo "$myHost is alive"
                if  [ $(grep -c "$myHost" "$down_hosts") -eq 1 ]; then
                        echo "Host : $myHost is up (ping ok) at $(date)"
                        sed -i "/$myHost/d" "$down_hosts"
                fi
        fi
done