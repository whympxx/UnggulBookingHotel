// Scene 3D interaktif (Three.js): gedung hotel low-poly di atas pulau melayang,
// cincin emas berputar, partikel bintang, dan orb-orb kecil. Kamera mengikuti
// gerakan mouse. Dipakai di hero beranda (variant "hero") dan halaman login ("auth").
(function () {
    function webglAvailable() {
        try {
            const c = document.createElement('canvas');
            return !!(window.WebGLRenderingContext && (c.getContext('webgl') || c.getContext('experimental-webgl')));
        } catch (e) { return false; }
    }

    // Tekstur jendela (beberapa menyala) digambar di canvas
    function windowTexture(THREE, cols, rows, seed) {
        const canvas = document.createElement('canvas');
        canvas.width = cols * 16; canvas.height = rows * 16;
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#141a3c';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        let s = seed;
        const rand = () => (s = (s * 9301 + 49297) % 233280) / 233280;
        for (let y = 0; y < rows; y++) {
            for (let x = 0; x < cols; x++) {
                const lit = rand() > 0.42;
                ctx.fillStyle = lit ? (rand() > 0.3 ? '#ffd27a' : '#a5b4fc') : '#232a55';
                ctx.fillRect(x * 16 + 4, y * 16 + 3, 8, 10);
            }
        }
        const tex = new THREE.CanvasTexture(canvas);
        tex.magFilter = THREE.NearestFilter;
        return tex;
    }

    function build(container) {
        const THREE = window.THREE;
        const variant = container.dataset.variant || 'hero';
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        renderer.setClearColor(0x000000, 0);
        container.appendChild(renderer.domElement);

        const scene = new THREE.Scene();
        scene.fog = new THREE.Fog(0x0b1026, 18, 42);
        const camera = new THREE.PerspectiveCamera(42, 1, 0.1, 100);
        camera.position.set(0, 3.2, 16);

        // Cahaya
        scene.add(new THREE.AmbientLight(0x8b8fd9, 0.55));
        const key = new THREE.DirectionalLight(0xffffff, 0.9);
        key.position.set(6, 10, 8);
        scene.add(key);
        const purple = new THREE.PointLight(0x8b5cf6, 2.2, 30);
        purple.position.set(-6, 4, 4);
        scene.add(purple);
        const gold = new THREE.PointLight(0xf5b942, 2, 25);
        gold.position.set(5, -1, 5);
        scene.add(gold);

        const world = new THREE.Group();
        scene.add(world);

        // Pulau melayang
        const island = new THREE.Group();
        const topMat = new THREE.MeshStandardMaterial({ color: 0x3b3f8f, roughness: 0.8, flatShading: true });
        const rockMat = new THREE.MeshStandardMaterial({ color: 0x1e1b4b, roughness: 1, flatShading: true });
        const top = new THREE.Mesh(new THREE.CylinderGeometry(4.2, 4, 0.5, 9), topMat);
        island.add(top);
        const rock = new THREE.Mesh(new THREE.ConeGeometry(4, 3.4, 9), rockMat);
        rock.rotation.x = Math.PI;
        rock.position.y = -1.95;
        island.add(rock);
        island.position.y = -2.2;
        world.add(island);

        // Gedung hotel
        const hotel = new THREE.Group();
        function tower(w, h, d, x, z, seed) {
            const tex = windowTexture(THREE, Math.round(w * 3), Math.round(h * 2.4), seed);
            const mat = new THREE.MeshStandardMaterial({ color: 0x2a2f6b, emissive: 0xffffff, emissiveMap: tex, emissiveIntensity: 0.85, roughness: 0.4, metalness: 0.3 });
            const mesh = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), [mat, mat, new THREE.MeshStandardMaterial({ color: 0x4c51bf, flatShading: true }), mat, mat, mat]);
            mesh.position.set(x, h / 2 - 1.95, z);
            hotel.add(mesh);
            return mesh;
        }
        const main = tower(1.8, 5.6, 1.8, 0, 0, 7);
        tower(1.3, 3.4, 1.4, -1.7, 0.4, 13);
        tower(1.3, 2.6, 1.4, 1.7, 0.3, 29);

        // Atap + kolam renang + menara antena
        const roof = new THREE.Mesh(new THREE.BoxGeometry(2, 0.18, 2), new THREE.MeshStandardMaterial({ color: 0xf5b942, metalness: 0.6, roughness: 0.3 }));
        roof.position.y = main.position.y + 2.9;
        hotel.add(roof);
        const pool = new THREE.Mesh(new THREE.BoxGeometry(1, 0.06, 0.6), new THREE.MeshStandardMaterial({ color: 0x22d3ee, emissive: 0x0891b2, emissiveIntensity: 0.8 }));
        pool.position.set(1.7, 0.72, 0.3);
        hotel.add(pool);
        const antenna = new THREE.Mesh(new THREE.CylinderGeometry(0.04, 0.04, 1.2), new THREE.MeshStandardMaterial({ color: 0xe2e8f0 }));
        antenna.position.y = roof.position.y + 0.6;
        hotel.add(antenna);
        const beacon = new THREE.Mesh(new THREE.SphereGeometry(0.11, 16, 16), new THREE.MeshBasicMaterial({ color: 0xff5470 }));
        beacon.position.y = antenna.position.y + 0.62;
        hotel.add(beacon);
        world.add(hotel);

        // Pohon low-poly
        const treeMat = new THREE.MeshStandardMaterial({ color: 0x10b981, flatShading: true });
        [[-3, 1.6], [2.9, -1.8], [-2.6, -2], [3.1, 1.9], [0.2, 2.9]].forEach(([x, z], i) => {
            const t = new THREE.Mesh(new THREE.ConeGeometry(0.35 + (i % 2) * 0.1, 0.9, 6), treeMat);
            t.position.set(x, -1.45, z);
            world.add(t);
        });

        // Cincin emas
        const ringMat = new THREE.MeshStandardMaterial({ color: 0xf5b942, metalness: 0.9, roughness: 0.25, emissive: 0x7a4a00, emissiveIntensity: 0.3 });
        const ring1 = new THREE.Mesh(new THREE.TorusGeometry(5.6, 0.05, 16, 120), ringMat);
        ring1.rotation.x = Math.PI / 2.3;
        world.add(ring1);
        const ring2 = new THREE.Mesh(new THREE.TorusGeometry(6.4, 0.025, 16, 120), new THREE.MeshBasicMaterial({ color: 0xa78bfa, transparent: true, opacity: 0.6 }));
        ring2.rotation.x = Math.PI / 1.8;
        ring2.rotation.y = 0.4;
        world.add(ring2);

        // Orb yang mengorbit
        const orbs = [];
        const orbColors = [0xf5b942, 0x8b5cf6, 0x22d3ee, 0xf472b6];
        for (let i = 0; i < 7; i++) {
            const orb = new THREE.Mesh(new THREE.IcosahedronGeometry(0.18 + Math.random() * 0.2, 0),
                new THREE.MeshStandardMaterial({ color: orbColors[i % 4], flatShading: true, emissive: orbColors[i % 4], emissiveIntensity: 0.25 }));
            orb.userData = { r: 5 + Math.random() * 1.5, speed: 0.15 + Math.random() * 0.25, offset: Math.random() * Math.PI * 2, y: -1 + Math.random() * 4 };
            world.add(orb);
            orbs.push(orb);
        }

        // Partikel bintang
        const count = variant === 'hero' ? 900 : 500;
        const positions = new Float32Array(count * 3);
        for (let i = 0; i < count; i++) {
            positions[i * 3] = (Math.random() - 0.5) * 60;
            positions[i * 3 + 1] = (Math.random() - 0.3) * 30;
            positions[i * 3 + 2] = (Math.random() - 0.5) * 40 - 8;
        }
        const starGeo = new THREE.BufferGeometry();
        starGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        const stars = new THREE.Points(starGeo, new THREE.PointsMaterial({ color: 0xc7d2fe, size: 0.07, transparent: true, opacity: 0.85 }));
        scene.add(stars);

        // Posisi sesuai layout
        function layout() {
            const w = container.clientWidth, h = container.clientHeight;
            renderer.setSize(w, h, false);
            renderer.domElement.style.width = '100%';
            renderer.domElement.style.height = '100%';
            camera.aspect = w / h;
            camera.updateProjectionMatrix();
            const wide = w > 900;
            if (variant === 'hero') {
                world.position.x = wide ? 6.2 : 0;
                world.userData.baseY = wide ? 0 : -1.5;
                world.scale.setScalar(wide ? 0.82 : 0.7);
            } else {
                world.position.x = 0;
                world.userData.baseY = w > 700 ? 2.2 : 1.2;
                world.scale.setScalar(w > 700 ? 0.55 : 0.5);
            }
        }
        layout();
        window.addEventListener('resize', layout);

        // Interaksi mouse / sentuh
        const target = { x: 0, y: 0 };
        window.addEventListener('pointermove', e => {
            target.x = (e.clientX / window.innerWidth - 0.5) * 2;
            target.y = (e.clientY / window.innerHeight - 0.5) * 2;
        }, { passive: true });

        // Hanya render saat terlihat
        let visible = true;
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(([en]) => { visible = en.isIntersecting; }).observe(container);
        }

        const clock = new THREE.Clock();
        function frame() {
            requestAnimationFrame(frame);
            if (!visible || document.hidden) return;
            const t = reduceMotion ? 0 : clock.getElapsedTime();

            world.rotation.y = t * 0.12 + target.x * 0.35;
            world.rotation.x = target.y * 0.08;
            world.position.y += ((world.userData.baseY || 0) + Math.sin(t * 0.8) * 0.15 - world.position.y) * 0.05;
            ring1.rotation.z = t * 0.25;
            ring2.rotation.z = -t * 0.18;
            beacon.material.color.setHSL(0.97, 1, 0.55 + Math.sin(t * 4) * 0.15);
            orbs.forEach(o => {
                const a = t * o.userData.speed + o.userData.offset;
                o.position.set(Math.cos(a) * o.userData.r, o.userData.y + Math.sin(a * 2) * 0.4, Math.sin(a) * o.userData.r);
                o.rotation.x = o.rotation.y = a * 2;
            });
            stars.rotation.y = t * 0.01;
            camera.position.x += (target.x * 1.2 - camera.position.x) * 0.04;
            camera.position.y += (3.2 - target.y * 0.8 - camera.position.y) * 0.04;
            camera.lookAt(world.position.x * 0.5, 0.5, 0);

            renderer.render(scene, camera);
        }
        frame();
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-hero3d]').forEach(el => {
            if (!window.THREE || !webglAvailable()) {
                el.classList.add('no-webgl'); // fallback: gradient + gambar latar tetap tampil
                return;
            }
            try { build(el); } catch (e) { console.warn('3D scene gagal dimuat:', e); }
        });
    });
})();
