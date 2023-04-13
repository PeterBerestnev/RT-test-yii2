FROM node:12-alpine as front

WORKDIR /usr/src/app

COPY ./vuejs ./
# RUN npm install
WORKDIR /usr/src/app
RUN npm install
CMD npm run serve