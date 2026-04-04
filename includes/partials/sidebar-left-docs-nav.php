<?php
/**
 * Left column documentation-style nav (Alpine accordion). Shared by home and news archive.
 */
?>
    <aside class="w-full lg:w-[250px] space-y-3">
        <nav class="text-[#a1722f] space-y-1" x-data="{
                 openMenu: 'Game Guide',
                 menus: [
                     { name: 'News', icon: 'fa-newspaper' },
                     { name: 'Toolkit', icon: 'fa-wrench' },
                     { name: 'Compendium', icon: 'fa-cogs' },
                     { name: 'Media', icon: 'fa-photo-video' },
                     { name: 'Community', icon: 'fa-users' },
                     { name: 'Support', icon: 'fa-life-ring' }
                 ]
             }">
            <template x-for="menu in menus" :key="menu.name">
                <div class="rounded-md overflow-hidden">
                    <h2 @click="openMenu = (openMenu === menu.name ? '' : menu.name)" class="panel-header px-3 py-2 text-lg flex justify-between items-center shadow-lg font-heading">
                        <div class="flex items-center">
                            <i class="fas fa-fw" :class="menu.icon + ' mr-2'"></i>
                            <span x-text="menu.name"></span>
                        </div>
                        <i class="fas fa-xs" :class="openMenu === menu.name ? 'fa-minus' : 'fa-plus'"></i>
                    </h2>
                    <ul x-show="openMenu === menu.name" x-transition class="text-sm text-[#a1722f]/90 bg-[#221502]/50 p-2 shadow-inner">
                        <template x-if="menu.name === 'News'">
                            <div>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5">Latest News</a></li>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5">Archived News</a></li>
                                <li><a href="#" class="hover:text-[#a1722f] block py-1.5">Release Notes</a></li>
                            </div>
                        </template>
                        <template x-if="menu.name === 'Toolkit'">
                            <div>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Dice Roller</a></li>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Initiative Tracker</a></li>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Compendium</a></li>
                                <li><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Character Sheet</a></li>
                            </div>
                        </template>
                        <template x-if="menu.name === 'Compendium'">
                            <div>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Introduction</a></li>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Getting Started</a></li>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- The World</a></li>
                                <li><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Story</a></li>
                            </div>
                        </template>
                        <template x-if="menu.name === 'Media'">
                            <div>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Screenshots</a></li>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Youtube Videos</a></li>
                                <li><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Downloads</a></li>
                            </div>
                        </template>
                        <template x-if="menu.name === 'Community'">
                            <div>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Discord</a></li>
                                <li><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Forums</a></li>
                            </div>
                        </template>
                        <template x-if="menu.name === 'Support'">
                            <div>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Bug Tracker</a></li>
                                <li><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Contact</a></li>
                            </div>
                        </template>
                        <template x-if="!['News', 'Account', 'Toolkit', 'Compendium', 'Media', 'Community', 'Support'].includes(menu.name)">
                            <li><a href="#" class="hover:text-[#a1722f] block py-1.5" x-text="`All ${menu.name}`"></a></li>
                        </template>
                    </ul>
                </div>
            </template>
        </nav>
    </aside>
