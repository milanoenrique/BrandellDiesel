document.addEventListener('DOMContentLoaded',()=>{

    document.querySelectorAll('.bdi-collapse-event').forEach((btnItem)=>{
        btnItem.addEventListener('click',(e)=>{

            e.preventDefault();

            const mainMenu= document.querySelector('body');

            if (!mainMenu.classList.contains('bdi-collapse-sidebar')) {
                mainMenu.classList.add('bdi-collapse-sidebar');
            }else{

                if (!mainMenu.classList.contains('bdi-standar-sidebar')){
                    mainMenu.classList.add('bdi-standar-sidebar');
                }else{
                    mainMenu.classList.remove('bdi-standar-sidebar');
                }

            }

        });

    });
});