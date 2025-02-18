#!/bin/bash

URL="http://cyber.blog:8000/" 
CONCURRENT_REQUESTS=5000
BLOCKED_COUNT=0

echo "Inizio attacco DoS simulato a $URL con $CONCURRENT_REQUESTS richieste..."

for i in $(seq 1 $CONCURRENT_REQUESTS)
do
    RESPONSE_CODE=$(curl -s -o /dev/null -w "%{http_code}" "$URL")
    
    if [ "$RESPONSE_CODE" -eq 429 ]; then
        echo "❌ Attacco bloccato alla richiesta numero $i con errore 429 (Too Many Requests)"
        BLOCKED_COUNT=$((BLOCKED_COUNT + 1))
        exit 0
    fi
done

if [ "$BLOCKED_COUNT" -gt 0 ]; then
    echo "Attacco mitigato! Il rate limiter ha bloccato $BLOCKED_COUNT richieste."
else
    echo "Attacco DoS simulato completato."
fi
