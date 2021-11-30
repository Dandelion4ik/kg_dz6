<!DOCTYPE html>
<html lang="eng">
<head>
    <title>Bezier_Algorithm</title>
</head>
<body>
<canvas id="kg_dz6" width="600" height="600" style='border:1px solid #000'>
</canvas>
<script>
    const canvas = document.getElementById("kg_dz6");
    const ctx = canvas.getContext('2d');

    function line(x0, y0, x1, y1, color) {
        ctx.fillStyle = color;
        let dy = Math.abs(y1 - y0);
        let dx = Math.abs(x1 - x0);
        let d_max = Math.max(dx, dy);
        let d_min = Math.min(dx, dy);
        let x_dir = 1;
        if (x1 < x0) x_dir = -1;
        let y_dir = 1;
        if (y1 < y0) y_dir = -1;
        let eps = 0;
        let s = 1;
        let k = 2 * d_min;
        if (dy <= dx) {
            let y = y0;
            for (let x = x0; x * x_dir <= x1 * x_dir; x += x_dir) {
                ctx.fillRect(x * s, y * s, s, s);
                eps = eps + k;
                if (eps > d_max) {
                    y += y_dir;
                    eps = eps - 2 * d_max;
                }
            }
        } else {
            let x = x0;
            for (let y = y0; y * y_dir <= y1 * y_dir; y += y_dir) {
                ctx.fillRect(x * s, y * s, s, s);
                eps = eps + k;
                if (eps > d_max) {
                    x += x_dir;
                    eps = eps - 2 * d_max;
                }
            }
        }
    }

    let state = 0;
    let Px0;
    let Py0;
    let Px1;
    let Py1;
    let Px2;
    let Py2;
    let P0x;
    let P0y;
    let P1x;
    let P1y;
    let P2x;
    let P2y;
    let P0x_;
    let P0y_;
    let P1x_;
    let P1y_;
    let P2x_;
    let P2y_;
    let pointsArrX = [];
    let pointsArrY = [];
    let pointsArrX_ = [];
    let pointsArrY_ = [];
    canvas.addEventListener("click", function (e) {
        if (state === 0) {
            Px0 = e.offsetX;
            Py0 = e.offsetY;
            state = 1;
        } else if (state === 1) {
            Px1 = e.offsetX;
            Py1 = e.offsetY;
            line(Px0, Py0, Px1, Py1, "#fff200");
            state = 2;
        } else if (state === 2) {
            Px2 = e.offsetX;
            Py2 = e.offsetY;
            line(Px1, Py1, Px2, Py2, "#fff200");
            P0x = Px0;
            P0y = Py0;
            P1x = Px1;
            P1y = Py1;
            P2x = Px2;
            P2y = Py2;
            P0x_ = Px0;
            P0y_ = Py0;
            P1x_ = Px1;
            P1y_ = Py1;
            P2x_ = Px2;
            P2y_ = Py2;

            function CheckPointsIsValid(Px0, Py0, Px1, Py1, Px2, Py2) {
                let d = ((Py2 - Py0) * Px1 + (Px0 - Px2) * Py1 - Px0 * Py2 + Px2 * Py0)
                    / (Math.sqrt((Px0 - Px2) * (Px0 - Px2) + (Py0 - Py2) * (Py0 - Py2)));
                if (d <= 1) {
                    line(Px0, Py0, Px2, Py2, "#ff0000");
                    return d;
                } else return d;
            }

            let t;
            while (CheckPointsIsValid(P0x, P0y, P1x, P1y, P2x, P2y) >= 1) {
                for (t = 0.5; t > 0.01; t /= 2) {
                    let P00x = (1 - t) * (1 - t) * P0x + 2 * (1 - t) * t * P1x + t * t * P2x;
                    let P00y = (1 - t) * (1 - t) * P0y + 2 * (1 - t) * t * P1y + t * t * P2y;
                    pointsArrX.push(P00x);
                    pointsArrY.push(P00y);
                    P2x = P00x;
                    P2y = P00y;
                    P1x = (1 - t) * P0x + t * P1x;
                    P1y = (1 - t) * P0y + t * P1y;
                }
            }
            while (CheckPointsIsValid(P0x_, P0y_, P1x_, P1y_, P2x_, P2y_) >= 1) {
                let P00x_ = (1 - t) * (1 - t) * P0x_ + 2 * (1 - t) * t * P1x_ + t * t * P2x_;
                let P00y_ = (1 - t) * (1 - t) * P0y_ + 2 * (1 - t) * t * P1y_ + t * t * P2y_;
                pointsArrX_.push(P00x_);
                pointsArrY_.push(P00y_);
                P1x_ = (1 - t) * P1x_ + t * P2x_;
                P1y_ = (1 - t) * P1y_ + t * P2y_;
                P0x_ = P00x_;
                P0y_ = P00y_;

            }
            for (let i = 0; i < pointsArrX_.length; i += 1) {
                line(pointsArrX_[i], pointsArrY_[i], pointsArrX_[i + 1], pointsArrY_[i + 1], "#ff0000");
            }
            state = 3;
        }
    });
</script>
</body>
</html>