<HTML lang="ru">
<meta charset="UTF-8">
<p>
</p>
<BODY>
<canvas id='homework06' width='400px' height='400px' style='border:10px groove #000000'>
</canvas>
<script>

    function Line(ctx, x_start, y_start, x_end, y_end, color){
        ctx.fillStyle = color;
        let d_max = Math.max(Math.abs(x_end - x_start), Math.abs(y_end - y_start));
        let d_min = Math.min(Math.abs(x_end - x_start), Math.abs(y_end - y_start));
        let x_dir = 1;
        if (x_end < x_start) x_dir = -1;
        let y_dir = 1;
        if (y_end < y_start) y_dir = -1;
        let eps = 0;
        let s = 1;
        let k = 2 * d_min;
        if (Math.abs(y_end - y_start) <= Math.abs(x_end - x_start)) {
            let y = y_start;
            for (let x = x_start; x * x_dir <= x_end * x_dir; x += x_dir) {
                ctx.fillRect(x * s, y * s, s, s);
                eps = eps + k;
                if (eps > d_max) {
                    y += y_dir;
                    eps = eps - 2 * d_max;
                }
            }
        } else {
            let x = x_start;
            for (let y = y_start; y * y_dir <= y_end * y_dir; y += y_dir) {
                ctx.fillRect(x * s, y * s, s, s);
                eps = eps + k;
                if (eps > d_max) {
                    x += x_dir;
                    eps = eps - 2 * d_max;
                }
            }
        }
    }

    function BezierCurve(f0, f1, f2){
        let k = (f2[1] - f0[1])/(f2[0] - f0[0]);
        console.log('Coefficient', k);
        let b = -1*k*f0[0] + f0[1];
        let d = Math.abs(-k*f1[0] + f1[1] - 1*b)/Math.sqrt(k*k + 1);
        console.log('Distance ',d);

        let f0_;
        let f1_;
        let f0__;
        if (d > 1) {
            f0_ = [];
            f0_[0] = 0.5 * f0[0] + 0.5 * f1[0];
            f0_[1] = 0.5 * f0[1] + 0.5 * f1[1];

            f1_ = [];
            f1_[0] = 0.5 * f1[0] + 0.5 * f2[0];
            f1_[1] = 0.5 * f1[1] + 0.5 * f2[1];

            f0__ = [];
            f0__[0] = 0.5 * f0_[0] + 0.5 * f1_[0];
            f0__[1] = 0.5 * f0_[1] + 0.5 * f1_[1];
            Line(ctx, f0_[0], f0_[1], f1_[0], f1_[1])
            BezierCurve(f0, f0_, f0__);

        } else {
            Line(ctx, f0_[0], f0_[1], f1_[0], f1_[1]);
        }
        if(d > 1){
            f0_ = [];
            f0_[0] = 0.5*f0[0] + 0.5*f1[0];
            f0_[1] = 0.5*f0[1] + 0.5*f1[1];

            f1_ = [];
            f1_[0] = 0.5*f1[0] + 0.5*f2[0];
            f1_[1] = 0.5*f1[1] + 0.5*f2[1];

            f0__ = [];
            f0__[0] = 0.5*f0_[0] + 0.5*f1_[0];
            f0__[1] = 0.5*f0_[1] + 0.5*f1_[1];
            Line(ctx, f0_[0], f0_[1], f1_[0], f1_[1])
            BezierCurve(f0__, f1_, f2);

        }else{
            Line(ctx, f0_[0], f0_[1], f1_[0], f1_[1]);
        }
    }

</script>
<script>
    let canvas = document.getElementById("dz06");
    let ctx = canvas.getContext("2d");
    let x = 0;
    let y = 0;
    let state = 0;
    let points = [];
    let counter = 0;

    canvas.addEventListener("click", function(event){
        x = event.offsetX
        y = event.offsetY
        if (state === 0) {
            points[counter] = [x, y];
            state = 1;

        } else if (state === 1) {
            points[counter] = [x, y];
            Line(ctx, points[0][0], points[0][1], points[1][0], points[1][1]);
            state = 2;

        } else if (state === 2) {
            points[counter] = [x, y];
            Line(ctx, points[1][0], points[1][1], points[2][0], points[2][1]);
            state = -1;

        }else if(state === -1){
            f0 = points[0];
            f1 = points[1];
            f2 = points[2];
            state = -2;

            BezierCurve(f0, f1, f2);
        }else if(state === -2){
            points = [];
            state = 0;
            counter = -1;
        }
        counter += 1;

    });
</script>
</BODY>
</HTML>