<template>
    <nav
        v-if="paginationLinks && paginationLinks.length > 3"
        class="my-5 d-flex"
    >
        <ul class="pagination mx-auto">
            <li class="page-item">
                <a :href="paginationLinks[0].url" class="page-link">&lt;&lt;</a>
            </li>
            <li
                v-for="link in paginationLinks.slice(1, -1)"
                :key="link.url"
                class="page-item"
                :class="{ active: link.active }"
            >
                <a :href="link.url" class="page-link">{{ link.label }}</a>
            </li>
            <li class="page-item">
                <a :href="paginationLinks.at(-1).url" class="page-link"
                    >&gt;&gt;</a
                >
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        paginationLinks: Array,
    },
};
</script>
