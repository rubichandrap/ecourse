/* show and hide sidebar */
$(document).ready(function () {
    function showSideBar() {
        $('.menu-icon').addClass('clicked').siblings('#sidebar').addClass('clicked');
    }

    function closeSideBar() {
        $('.close-icon').parent().removeClass('clicked')
            .siblings('.menu-icon').removeClass('clicked');
    }

    $('.menu-icon').click(showSideBar);
    $('.close-icon').click(closeSideBar);

    $('#app').mouseup(function (e) {
        var $target = $('#sidebar');
        //Cek apabila target bukan #sidebar, dan yang ditarget pada #sidebar adalah 0
        //alias user tidak berinteraksi dengan #sidebar & child element dari #sidebar
        if (!$target.is(e.target) && $target.has(e.target).length === 0) {
            closeSideBar();
        }
    });

    /* gotop btn */

    function goTop() {
        var gotop = document.getElementsByClassName('go-top');
        function showGoTop() {
            if (gotop) {
                if (window.scrollY < 200) {
                    $(gotop).css('display', 'none');
                }
                else {
                    $(gotop).css('display', 'block');
                }
            }
        }

        showGoTop();

        $(document).on('scroll', showGoTop);

        $(gotop).click(function () {
            window.scrollTo({ top: 0, behavior: 'smooth', });
        });
    }

    goTop();
});

/* MUTE COLOR TEXT INSIDE INPUT DATE WHEN PAGE IS ACTUALLY LOADDED */

const changeColorDate = () => {
    const doChange = () => {
        const inputsDate = Array.from(document.querySelectorAll('input[type="date"]'));

        if (inputsDate.length > 0) {

            inputsDate.forEach(inputDate => {
                inputDate.addEventListener('keyup', () => {
                    if (inputDate.value === "") {
                        inputDate.style.color = "#8898aa";
                    } else {
                        inputDate.style.color = "#495057";
                    }
                });
            });
        }
    }

    window.addEventListener('load', doChange);
}

changeColorDate();


/*live search */
const jsLiveSearch = () => {
    const form = document.querySelector('.js-live-search');
    const addLink = document.querySelector('#add-link');
    let txtValue;
    if (form) {
        function checkMatches() {
            const input = form.querySelector('input');
            let filter = input.value.toUpperCase();
            const table = document.querySelector('.js-live-search-table');
            const ul = document.querySelector('.js-live-search-list');
            if (table) {
                const tbody = table.querySelector('tbody');
                let tr = tbody.querySelectorAll('tr');
                let th = tbody.querySelectorAll('th');

                for (let i = 0; i < th.length; i++) {
                    let a = th[i].querySelectorAll('a')[0];
                    txtValue = a.textContent || a.innerText;

                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    }
                    else {
                        tr[i].style.display = 'none';
                        if (addLink) {
                            addLink.style.display = '';
                        }
                    }
                }
            }
            if (ul) {
                let li = Array.from(ul.querySelectorAll('li'));
                let active = ul.querySelector('.active');
                li.forEach(i => {
                    a = i.querySelectorAll('a');
                    a.forEach(j => {
                        txtValue = j.textContent || j.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            i.classList.add('d-flex');
                        }
                        else {
                            i.style.display = 'none';
                            i.classList.remove('d-flex');
                        }
                    });
                    active.style.display = '';
                    active.classList.add('d-flex');
                });
            }
        }

        form.addEventListener('keyup', function () {
            checkMatches();
        });
    }
}

jsLiveSearch();

const jsLiveSearchAdditional = () => {
    const formAbsent = document.querySelector('.js-live-search-absent');
    const formSession = document.querySelector('.js-live-search-session');
    const addLink = document.querySelector('#add-link');
    let txtValue;
    if (formAbsent) {
        function checkMatches() {
            const input = formAbsent.querySelector('input');
            let filter = input.value.toUpperCase();
            const table = document.querySelector('.js-live-search-table');
            if (table) {
                const tbody = table.querySelector('tbody');
                let tr = tbody.querySelectorAll('tr');
                let th = tbody.querySelectorAll('th');

                for (let i = 0; i < th.length; i++) {
                    let a = th[i].querySelectorAll('a')[0];
                    txtValue = a.textContent || a.innerText;

                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    }
                    else {
                        tr[i].style.display = 'none';
                        if (addLink) {
                            addLink.style.display = '';
                        }
                    }
                }
            }

        }

        formAbsent.addEventListener('keyup', function () {
            checkMatches();
        });
    }

    if (formSession) {
        function checkMatches() {
            const input = formSession.querySelector('input');
            let filter = input.value.toUpperCase();
            const ul = document.querySelector('.js-live-search-list');
            if (ul) {
                let li = Array.from(ul.querySelectorAll('li'));
                let active = ul.querySelector('.active');
                li.forEach(i => {
                    a = i.querySelectorAll('a');
                    a.forEach(j => {
                        txtValue = j.textContent || j.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            i.classList.add('d-flex');
                        }
                        else {
                            i.style.display = 'none';
                            i.classList.remove('d-flex');
                        }
                    });
                    active.style.display = '';
                    active.classList.add('d-flex');
                });
            }
        }
        formSession.addEventListener('keyup', function () {
            checkMatches();
        });
    }
}

jsLiveSearchAdditional();

/* hide success session alert after redirect */
const hideAlert = () => {
    const success = document.querySelector('.alert-success');
    const danger = document.querySelector('.alert-danger');
    if (success) {
        setTimeout(() => {
            $(success).animate({ opacity: 0 }, 2000);
        }, 5000);
        setTimeout(() => {
            success.style.display = 'none';
        }, 7000);
    }
    if (danger) {
        setTimeout(() => {
            $(danger).animate({ opacity: 0 }, 2000);
        }, 5000);
        setTimeout(() => {
            danger.style.display = 'none';
        }, 7000);
    }
}

window.addEventListener('load', hideAlert);

const filterUserPosts = () => {
    
    const btnPost = document.querySelector('#btn-post-filter');

    if(btnPost) {
        const dataParse = btnPost.getAttribute('data-parse');
        let postings = Array.from(document.querySelectorAll('.postings'));
        const postToggle = btnPost.querySelector('#post-toggle');
        const checkIcon = postToggle.querySelector('#check-icon');
        const timesIcon = postToggle.querySelector('#times-icon');

        const filterMatches = () => {
            postings.forEach(posting => {
                if (postToggle.classList.contains('clicked')) {  // check apakah postToggle memiliki class clicked
                    
                    dataTarget = posting.getAttribute('data-target'); // value dari data target berubah ubah sesuai loop dari posting
                                                                    // contoh posting memiliki attr data-target = 12345, maka data target nilainya 12345,
                                                                    // kemudian loop berikutnya posting memiliki data target= 54321, maka data target nilainya 54321

                    if (dataParse === dataTarget) {
                        posting.style.display = ''; //tampilkan semua posting yang memiliki attr data target yang sama dengan data parse
                    }
                    else {
                        posting.style.display = 'none'; // sembunyikan posting yang memiliki perbedaan antara parse dengan target
                    }
                }
                else {
                    posting.style.display = ''; //tampilkan semua posting apabila post toggle tidak memiliki class clicked
                }
            });
        }

        const animateBtn = () => {
            
            if (postToggle.classList.contains('clicked')) {
                checkIcon.style.display = 'none';
                timesIcon.style.display = ''
            }
            else {
                checkIcon.style.display = '';
                timesIcon.style.display = 'none';
            }
        }

        btnPost.addEventListener('click', () => {
            postToggle.classList.toggle('clicked');
            filterMatches();
            animateBtn();
        });
    }
}

filterUserPosts();


const showAndHideComment = () => {
    let commentBtns = Array.from(document.querySelectorAll('.comment-btn'));

    if (commentBtns) {
        let commentBodies = Array.from(document.querySelectorAll('.comment-wrapper'));
        commentBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                btn.classList.toggle('clicked');
                if (btn.classList.contains('clicked')) {
                    commentBodies[commentBtns.indexOf(btn)].style.display = '';
                }
                else {
                    commentBodies[commentBtns.indexOf(btn)].style.display = 'none';
                }
            });
        });
    }
}

showAndHideComment();