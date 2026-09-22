<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IoT Realtime Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        h1 { text-align: center; color: #333; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; max-width: 1000px; margin: 20px auto; }
        .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; }
        .card h3 { margin: 0; color: #666; font-size: 16px; }
        .card p { font-size: 28px; font-weight: bold; color: #007bff; margin: 10px 0 0 0; }
        .timestamp { text-align: center; color: #888; margin-top: 20px; font-size: 14px; }
    </style>
</head>
<body>

    <h1>IoT Realtime Dashboard (iot-000)</h1>
    
    <div class="grid">
        <div class="card"><h3>Temperature (°C)</h3><p id="temp">--</p></div>
        <div class="card"><h3>Humidity (%)</h3><p id="humi">--</p></div>
        <div class="card"><h3>Light (lx)</h3><p id="light">--</p></div>
        <div class="card"><h3>Pressure (hPa)</h3><p id="press">--</p></div>
        <div class="card"><h3>Battery (%)</h3><p id="battery">--</p></div>
        <div class="card"><h3>Status</h3><p id="status" style="color: #28a745;">--</p></div>
    </div>

    <div class="timestamp">อัปเดตล่าสุด: <span id="time">--</span></div>

    <script>
        // ใส่ URL Realtime Database ของคุณ (ลงท้ายด้วย /Lab.json)
        const FIREBASE_URL = "https://iot-000-7912d-default-rtdb.asia-southeast1.firebasedatabase.app/Lab.json";

        async function fetchData() {
            try {
                const response = await fetch(FIREBASE_URL);
                const data = await response.json();
                if (data) {
                    document.getElementById("temp").innerText = data.temp ? data.temp.toFixed(1) : "--";
                    document.getElementById("humi").innerText = data.humi ? data.humi.toFixed(1) : "--";
                    document.getElementById("light").innerText = data.light ? data.light.toFixed(0) : "--";
                    document.getElementById("press").innerText = data.press ? data.press.toFixed(1) : "--";
                    document.getElementById("battery").innerText = data.battery ? data.battery.toFixed(0) : "--";
                    document.getElementById("status").innerText = data.status || "--";
                    
                    if (data.timestamp) {
                        const date = new Date(data.timestamp * 1000);
                        document.getElementById("time").innerText = date.toLocaleString("th-TH");
                    }
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        }

        // ดึงข้อมูลใหม่ทุกๆ 3 วินาที
        setInterval(fetchData, 3000);
        fetchData();
    </script>
</body>
</html>