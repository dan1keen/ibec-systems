<template>
    <div class="row justify-content-center">
        <div class="col-md-8" >
            <div class="card card-default">
                <div class="card-header">Действия</div>

                <div class="card-body">
                    <strong>Created: {{date[1]}}, Updated: {{date[2]}}, Deleted {{date[3]}}</strong>
                    <table class="table table-hover mt-2">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Дата</th>
                            <th>Овечка №</th>
                            <th>Статус</th>
                            <th>Описание</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="report in date[0] " :key="report.id">
                            <td>{{report.id}}</td>
                            <td>{{report.date}}</td>
                            <td>{{report.description.name}}</td>
                            <td>{{report.description.status}}</td>
                            <td v-if="report.description.status=='updated'">Sheep was transferred from {{report.description.old}} to {{report.description.new}}</td>
                            <td v-if="report.description.status=='deleted'">Sheep was deleted from {{report.description.corral}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                date: [],
            }
        },
        created() {
            let uri = `http://localhost:8000/api/report/${this.$route.params.key}`;
            this.axios.get(uri).then((response) => {
                this.date = response.data;
            });

        },

    }
</script>