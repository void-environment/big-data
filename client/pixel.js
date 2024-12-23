/**
    Сначала использовал - https://stackoverflow.com/questions/9514179/
    Потом взял более лёгкий код с учётом тестового
    Не использую async, try-catch, валидацию и т.д
*/

const domain = 'https://litec-soft.ru/big-data'

const pixelSetCookie = (visitId) => {
    const time = 60 * 60 * 24; // сутки
    document.cookie = `visitId=${visitId}; path=/; max-age=${time}`;
}

function pixelGetCookie(name) {
    const cookies = document.cookie.split("; ");
    for (const cookie of cookies) {
        const [key, value] = cookie.split("=");
        if (key === name) {
            return value;
        }
    }
    return undefined;
}

const pixelSendData = (data, point) => {

    fetch(`${domain}/api/v1/${point}/`, {
        method: "POST",
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    })
    .then(response => { return response.json(); })
    .then(data => {
        if(data.hasOwnProperty('visitId')) pixelSetCookie(data.visitId);
        console.log(data);
    })
}

const clientData = () => {

    const userAgent = navigator.userAgent;
    const platform = navigator.platform;

    const browser = (() => {
        const ua = userAgent.toLowerCase();
        if (ua.includes('chrome')) return 'Chrome';
        if (ua.includes('safari')) return 'Safari';
        if (ua.includes('firefox')) return 'Firefox';
        if (ua.includes('edge')) return 'Edge';
        if (ua.includes('opera') || ua.includes('opr')) return 'Opera';
        return 'Unknown';
    })();

    device = 'Unknown';
    if(/tablet|ipad/.test(userAgent.toLowerCase())) device = 'Tablet';
    else if(/mobile|android/.test(userAgent.toLowerCase())) device = 'Mobile';
    else device = 'Desktop';

    const data = {
        page: window.location.pathname,
        user_agent: userAgent,
        browser,
        platform,
        device: device
    };

    pixelSendData(data, 'visit');
}

document.querySelector('button').addEventListener('click', () => {

    const data = {
        email: document.querySelector('#email').value,
        phone: document.querySelector('#phone').value,
        visit_id: pixelGetCookie('visitId')
    };

    pixelSendData(data, 'contact');
});

if(pixelGetCookie('visitId') == undefined) clientData();