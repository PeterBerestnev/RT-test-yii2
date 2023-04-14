FROM node:12-alpine as front

WORKDIR /usr/src/app

COPY ./vuejs ./
RUN npm install
CMD npm run serve