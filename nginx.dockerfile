FROM nginx:stable-alpine

# Copy the Nginx configuration file
ADD vhost.conf /etc/nginx/conf.d/default.conf

# Copy the Laravel application files
COPY public /var/www/html/public

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]
