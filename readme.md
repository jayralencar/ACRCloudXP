# ACRCloud Experience
A experience with ACRCloud API to recognize music from a .mp3 or audio file.

## Get Started

### Downloading
```
git clone https://github.com/jayralencar/ACRCloudXP.git
```
### Dependencies
```
composer install
```
### Configuration
1. Visit [ACRCloud](https://www.acrcloud.com/pt/), create a account;
2. In the ACRCloud console go to Audio & Video Recognition;
3. Create a Project ([Tutorial](https://www.acrcloud.com/docs/acrcloud/tutorials/identify-music-by-sound/));
4. You need to change the .env file of your laravel project and add three new porperties:
```
ACR_HOST="http://###YOUR PROJECT HOST HERE###/v1/identify"
ACR_ACCESS_KEY=YOUR ACCESS KEY HERE
ACR_ACCESS_SECRET=YOUR ACCESS SECRET KEY HERE
```

## API information

``` 
POST api/v1/send-file 
```
This route receive a mp3 file with the target 'file'.