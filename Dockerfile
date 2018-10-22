FROM tutum/apache-php
RUN apt-get update && rm -rf /var/lib/apt/lists/*
RUN rm -fr /app
ADD . /app
