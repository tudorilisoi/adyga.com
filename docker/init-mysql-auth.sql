-- Set authentication plugin to caching_sha2_password for users
ALTER USER 'root'@'%' IDENTIFIED WITH caching_sha2_password BY 'lUnkeTibEMbI';
ALTER USER 'wordpress'@'%' IDENTIFIED WITH caching_sha2_password BY 'lUnkeTibEMbI';
FLUSH PRIVILEGES;
