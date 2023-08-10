<template>
    <body class="bg-main">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <slot name="content"></slot>
                </main>
            </div>
        </div>
    </body>
</template>

<style scoped>
.bg-main{
    background-image: url('assets/img/brand/background.svg');
    background-size: cover;
    background-position: center;
}

</style>