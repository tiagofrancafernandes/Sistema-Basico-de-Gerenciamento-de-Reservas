<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import { toastIt } from '@/primevue/helpers/prime-toast';
// import { CustomerService } from '@/service/CustomerService';

const CRUDService = {
    indexFor(resource, data = {}, options = {}) {
        let url = `https://hotel.local.tiagofranca.com/api/${resource}/index`;

        let payload = data || {};

        return fetch(url, {
            method: 'post',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                // Authorization: Bearer MyAuthToken
            },
            body: JSON.stringify(payload),
        });
    }
};

onMounted(() => {
    loading.value = true;

    lazyParams.value = {
        first: 0,
        rows: 10,
        sortField: null,
        sortOrder: null,
        filters: filters.value
    };

    loadLazyData();
    // toastIt('abc', 'info', -1); // No auto close
    // PrimeToast.info('abc', -1); // No auto close
    // PrimeToast.info('abc', 5000); // Will auto close in 5 seconds
    // PrimeToast.toast('abc');
    toastIt('teste toastIt');
});

const dt = ref();
const loading = ref(false);
const totalRecords = ref(0);
const customers = ref();
const selectedCustomers = ref();
const selectAll = ref(false);
const first = ref(0);
const filters = ref({
    'name': {value: '', matchMode: 'contains'},
    'country.name': {value: '', matchMode: 'contains'},
    'company': {value: '', matchMode: 'contains'},
    'representative.name': {value: '', matchMode: 'contains'},
});
const lazyParams = ref({});
const columns = ref([
    {field: 'name', header: 'Name'},
    {field: 'country.name', header: 'Country'},
    {field: 'company', header: 'Company'},
    {field: 'representative.name', header: 'Representative'}
]);

const loadLazyData = (event) => {
    loading.value = true;
    lazyParams.value = { ...lazyParams.value, first: event?.first || first.value };

    CRUDService.indexFor('guests', { lazyEvent: JSON.stringify(lazyParams.value) })
        .then((response) => {
            if (!response?.ok) {
                console.error('Not success response');
            }

            return response.json()
        })
        .then((data) => {
            console.log('data', data);
            customers.value = data.records;
            totalRecords.value = data.totalRecords;
            loading.value = false;
        });
};

const uncheckAllSelectedRows = (options = null) => {
    selectedCustomers.value = [];
    selectAll.value = false;
}

const onPage = (event) => {
    console.log('onPage', event);
    uncheckAllSelectedRows(); // Desmarca linhas previamente selecionadas
    lazyParams.value = event;
    loadLazyData(event);
};

const onSort = (event) => {
    lazyParams.value = event;
    loadLazyData(event);
};
const onFilter = (event) => {
    lazyParams.value.filters = filters.value ;
    loadLazyData(event);
};
const onSelectAllChange = (event) => {
    selectAll.value = event.checked;

    if (selectAll) {
        CRUDService.indexFor('guests').then(data => {
            console.log('data', data);
            selectAll.value = true;
            selectedCustomers.value = data.records;
        });
    }
    else {
        selectAll.value = false;
        selectedCustomers.value = [];
    }
};

const onRowSelect = () => {
    selectAll.value = selectedCustomers.value.length === totalRecords.value;
    toastIt('selected a raw', 'info', 5000);
};
const onRowUnselect = () => {
    selectAll.value = false;
    toastIt('unselected a raw', 'info', 5000);
};

let pageInfo = computed(() => ({
    pageTitle: 'Guests',
    headerTitle: 'Guests',
}))
</script>

<template>
    <Head :title="pageInfo.pageTitle" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >{{ pageInfo.headerTitle }}</h2>
        </template>

        <div class="py-4">
            <div class="card p-fluid">
                <DataTable
                    :value="customers" lazy paginator
                    :first="first"
                    :rows="10" v-model:filters="filters" ref="dt" dataKey="id"
                    :totalRecords="totalRecords"
                    :loading="loading" @page="onPage($event)" @sort="onSort($event)" @filter="onFilter($event)" filterDisplay="row"
                    :globalFilterFields="['name','country.name', 'company', 'representative.name']"
                    v-model:selection="selectedCustomers"
                    :selectAll="selectAll"
                    @select-all-change="onSelectAllChange"
                    @row-select="onRowSelect"
                    @row-unselect="onRowUnselect"
                    tableStyle="min-width: 75rem"
                >
                    <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
                    <Column field="name" header="Name" filterMatchMode="startsWith" sortable>
                        <template #filter="{filterModel,filterCallback}">
                            <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()" class="p-column-filter" placeholder="Search"/>
                        </template>
                    </Column>
                    <Column field="country.name" header="Country" filterField="country.name" filterMatchMode="contains" sortable>
                        <template #body="{ data }">
                            <div class="flex items-center gap-2">
                                <img alt="flag" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`flag flag-${data.country.code}`" style="width: 24px" />
                                <span>{{ data.country.name }}</span>
                            </div>
                        </template>
                        <template #filter="{filterModel,filterCallback}">
                            <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()" class="p-column-filter" placeholder="Search"/>
                        </template>
                    </Column>
                    <Column field="company" header="Company" filterMatchMode="contains" sortable>
                        <template #filter="{filterModel,filterCallback}">
                            <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()" class="p-column-filter" placeholder="Search"/>
                        </template>
                    </Column>
                    <Column field="representative.name" header="Representative" filterField="representative.name" sortable>
                        <template #body="{ data }">
                            <div class="flex items-center gap-2">
                                <img :alt="data.representative.name" :src="`https://primefaces.org/cdn/primevue/images/avatar/${data.representative.image}`" style="width: 32px" />
                                <span>{{ data.representative.name }}</span>
                            </div>
                        </template>
                        <template #filter="{filterModel,filterCallback}">
                            <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()" class="p-column-filter" placeholder="Search"/>
                        </template>
                    </Column>
                    <Column headerStyle="width:4rem">
                        <template #body>
                            <Button icon="pi pi-search" />
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
