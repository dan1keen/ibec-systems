<template>
    <div>
        <div>
            <div>
                <h1 style="text-align: center">Отчет</h1>
            </div>
        </div>

        <table class="table  mt-2">
            <thead>
            <tr>

                <th>Дата</th>
                <th>Действие</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(report, keys) in reports " :key="report.id">
                <td>{{keys}}</td>
                <td><router-link :to="{name: 'report', params: { key: keys }}" class="btn btn-success">Просмотреть</router-link></td>
              </tr>
            </tbody>
        </table>


    </div>

</template>

<script>
    export default {
        data(){
            return {
                reports: []
            }
        },
        created(){

            let uris = 'http://localhost:8000/api/reports';
            this.axios.get(uris).then((response) => {
                this.reports = response.data;
            });



        },
    }
</script>

<style scoped>

</style>