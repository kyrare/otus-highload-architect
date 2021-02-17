import http from 'k6/http';
import { sleep } from 'k6';

export default function () {
    http.get('http://89.223.122.122/users?q=Artem');
    sleep(1);
}
