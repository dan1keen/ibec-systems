<template>
    <div v-if="corrals.length">
        <div>
            <div>
                <h1 style="text-align: center">Список Загонов</h1>
            </div>
        </div>
        <div class="row">
            <div class="card col-md-3"  v-for="corral in corrals " :key="corral.id">
                <div class="card-header" style="text-align: center">
                    <strong>{{corral.name}} </strong>
                    <br>
                    <strong>Кол-во: {{corral.sheeps.length}}</strong>
                </div>
                <ul class="list-group list-group-flush" v-for="sheeps in corral.sheeps ">
                    <li class="list-group-item" style="text-align: center">{{sheeps.name}}</li>
                </ul>
            </div>
        </div>
        <h5 style="text-align: center">Команда для создания овечки в рандомном загоне: <strong>php artisan create:sheep</strong></h5>
        <h5 style="text-align: center">Команда для перемещения овечки из рандомного загона в загон где 1 овечка: <strong>php artisan check:sheep</strong></h5>
        <h5 style="text-align: center">Команда для удаления овечки из рандомного загона: <strong>php artisan remove:sheep</strong></h5>

    </div>
    <div v-else-if="!corrals.length">
        <h5 style="text-align: center">Загон и овечки еще не созданы, вы можете создать их с помощью команды: <br><strong>php artisan generate:rand-sheeps</strong></h5>
    </div>


</template>

<script>
    export default {
        data(){
            return {
                corrals: []
            }
        },
        created(){
            let uris = 'http://localhost:8000/api/corrals';

            this.axios.get(uris).then((response) => {
                    this.corrals = response.data;
            });



        },
    }
</script>

<style scoped>

</style>