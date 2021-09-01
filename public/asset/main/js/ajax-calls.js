/*ajax call untuk desc link, materi link dan faq */

const ajxModulTab = () => {
    const modulTab = document.querySelector('#modul-tab');

    if (modulTab) {
        const ajaxModul = document.querySelector('#ajax-modul');
        let a = Array.from(modulTab.querySelectorAll('a'));
        let slug = modulTab.getAttribute('data-parse');

        const fetchAndInsert = (dataContent) => {
            let lastPath, ajaxUrl;
            //back/forward handler
            lastPath = dataContent.split('/').pop();
            if (lastPath == slug) {
                ajaxUrl = '/modul/' + slug + '/' + a[0].getAttribute('data-content') + '/ajax';
            } else {
                // click handler
                ajaxUrl = '/modul/' + slug + '/' + lastPath + '/ajax';
            }

            //jquery approach
            $.ajax({
                type: 'get',
                url: ajaxUrl,
                cache: false,
                success: function (data) {
                    ajaxModul.innerHTML = data;
                    for (let i = 0; i < a.length; i++) {
                        a[i].classList.remove('active', 'disabled');
                        a[i].classList.add('border-0');

                        if (lastPath == a[i].getAttribute('data-content')) {
                            a[i].classList.add('active', 'disabled');
                            a[i].classList.remove('border-0');
                        }
                        // add active and disabled to a offset 0 if lastpath = slug
                        else if (lastPath == slug) {
                            a[0].classList.add('active', 'disabled');
                            a[0].classList.remove('border-0');
                        }
                    }
                    jsLiveSearch();
                },
                error: function () {
                    alert('Ada kesalahan silahkan coba lagi');
                }
            });
        }
        
        // user back/forward
        window.addEventListener('popstate', () => {
            let path = location.pathname;
            fetchAndInsert(path)
        });
        a.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                let path = location.pathname;
                let dataContent = item.getAttribute('data-content');
                let lastPath = path.split('/').pop();
                fetchAndInsert(dataContent);

                //manipulate history
                if (lastPath == slug) {
                    history.pushState(null, null, path + '/' + dataContent);
                }
                else {
                    history.pushState(null, null, dataContent);
                }
            });
        });
    }
}

ajxModulTab();

const ajxKelasTab = () => {
    const kelasTab = document.querySelector('#kelas-tab');

    if (kelasTab) {
        const ajaxKelas = document.querySelector('#ajax-kelas');
        let a = Array.from(kelasTab.querySelectorAll('a'));
        let id = kelasTab.getAttribute('data-parse');

        const fetchAndInsert = (dataContent) => {
            let lastPath, ajaxUrl;
            //back/forward handler
            lastPath = dataContent.split('/').pop();
            if (lastPath == id) {
                ajaxUrl = '/kelas/' + id + '/' + a[0].getAttribute('data-content') + '/ajax';
            } else {
                // click handler
                ajaxUrl = '/kelas/' + id + '/' + lastPath + '/ajax';
            }

            //jquery approach
            $.ajax({
                type: 'get',
                url: ajaxUrl,
                cache: false,
                success: function (data) {
                    ajaxKelas.innerHTML = data;
                    for (let i = 0; i < a.length; i++) {
                        a[i].classList.remove('active', 'disabled');
                        a[i].classList.add('border-0');

                        if (lastPath == a[i].getAttribute('data-content')) {
                            a[i].classList.add('active', 'disabled');
                            a[i].classList.remove('border-0');
                        }
                        // add active and disabled to a offset 0 if lastpath = id
                        else if (lastPath == id) {
                            a[0].classList.add('active', 'disabled');
                            a[0].classList.remove('border-0');
                        }
                    }
                    jsLiveSearch();
                },
                error: function () {
                    alert('Ada kesalahan silahkan coba lagi');
                }
            });
        }
        
        // user back/forward
        window.addEventListener('popstate', () => {
            let path = location.pathname;
            fetchAndInsert(path)
        });
        a.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                let path = location.pathname;
                let dataContent = item.getAttribute('data-content');
                let lastPath = path.split('/').pop();
                fetchAndInsert(dataContent);

                //manipulate history
                if (lastPath == id) {
                    history.pushState(null, null, path + '/' + dataContent);
                }
                else {
                    history.pushState(null, null, dataContent);
                }
            });
        });
    }
}

ajxKelasTab();


const ajxKelasMhsTab = () => {
    const kelasMhsTab = document.querySelector('#kelas-mahasiswa-tab');

    if (kelasMhsTab) {
        const ajaxKelasMhs = document.querySelector('#ajax-kelas-mahasiswa');
        let a = Array.from(kelasMhsTab.querySelectorAll('a'));

        const fetchAndInsert = (dataContent) => {
            let lastPath, ajaxUrl;
            //back/forward handler
            lastPath = dataContent.split('/').pop();
            if (lastPath == 'kelas') {
                ajaxUrl = '/kelas/' + a[0].getAttribute('data-content') + '/ajax';
            } else {
                // click handler
                ajaxUrl = '/kelas/' + lastPath + '/ajax';
            }

            //jquery approach
            $.ajax({
                type: 'get',
                url: ajaxUrl,
                cache: false,
                success: function (data) {
                    ajaxKelasMhs.innerHTML = data;
                    for (let i = 0; i < a.length; i++) {
                        a[i].classList.remove('active', 'disabled');
                        a[i].classList.add('border-0');

                        if (lastPath == a[i].getAttribute('data-content')) {
                            a[i].classList.add('active', 'disabled');
                            a[i].classList.remove('border-0');
                        }
                        // add active and disabled to a offset 0 if lastpath = kelas
                        else if (lastPath == 'kelas') {
                            a[0].classList.add('active', 'disabled');
                            a[0].classList.remove('border-0');
                        }
                    }
                    jsLiveSearch();
                },
                error: function () {
                    alert('Ada kesalahan silahkan coba lagi');
                }
            });
        }
        
        // user back/forward
        window.addEventListener('popstate', () => {
            let path = location.pathname;
            fetchAndInsert(path)
        });
        a.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                let path = location.pathname;
                let dataContent = item.getAttribute('data-content');
                let lastPath = path.split('/').pop();
                fetchAndInsert(dataContent);

                //manipulate history
                if (lastPath == 'kelas') {
                    history.pushState(null, null, path + '/' + dataContent);
                }
                else {
                    history.pushState(null, null, dataContent);
                }
            });
        });
    }
}

ajxKelasMhsTab();




/* ajax call untuk show more */

const ajxShowMore = () => {
    const holder = document.querySelector('#ajax-holder');

    if (holder) {
        const showLink = document.querySelector('#show-link');
        let sumData = document.querySelector('#sum-data').value;
        let searchData = document.querySelector('#search-data').value;

        const index = 6;
        let taker, counter;
        counter = 0;
        taker = 6;


        /* cek apakah ada data tersisa atau tidak */
        const checkAvailable = () => {
            if (taker >= sumData) {
                showLink.innerText = 'No more data available';
                showLink.classList.add('disabled');
            }
        }

        window.addEventListener('load', checkAvailable);

        showLink.addEventListener('click', (e) => {
            e.preventDefault();
            showLink.classList.add('disabled');
            counter++;
            taker = index + (counter * 3);
            $.ajax({
                type: 'get',
                url: 'home/retrieve',
                data: {
                    taker: taker,
                    sumData: sumData,
                    searchData: searchData,
                },
                success: function (data) {
                    holder.innerHTML = data;
                    showLink.classList.remove('disabled');
                    checkAvailable();
                },
                error: function () {
                    alert('Ada kesalahan silahkan coba lagi');
                }
            });
        });
    }
}

ajxShowMore();