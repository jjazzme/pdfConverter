FROM ubuntu:latest
RUN apt-get update && \
    apt-get install -y curl && \
    apt-get install -y nginx && \
    apt-get install -y autoconf automake libtool && \
    apt-get install -y nodejs npm && \
    apt-get install -y g++ && \
    apt-get install -y python3-lxml python3-polib && \
    apt-get install -y pkg-config && \
    apt-get install -y libreoffice && \
    apt-get install -y libpoco-dev libcap-dev libcppunit-dev librsvg2-bin fonts-crosextra-caladea libpng-dev && \
    apt-get install -y libpam0g-dev && \
    apt-get clean


#RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
#    apt-get install -y nodejs

RUN curl -LO https://github.com/LibreOffice/online/archive/refs/tags/cp-6.4.0-4.tar.gz && \
    tar xvzf cp-6.4.0-4.tar.gz && \
    cd online-cp-6.4.0-4 && \
    autoreconf -fiv && \
    ./configure --enable-silent-rules --with-lo-path=/usr/lib/libreoffice --with-lokit-path=/usr/include/libreoffice/source/include --enable-debug && \
    make && \
    make install && \
    cd /loleaflet && \
    npm install

COPY nginx.conf /etc/nginx/nginx.conf

EXPOSE 9980
EXPOSE 80

CMD ["/usr/local/bin/loolwsd", "--version"]
CMD ["nginx", "-g", "daemon off;"]