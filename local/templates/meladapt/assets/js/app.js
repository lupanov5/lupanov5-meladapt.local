import 'core-js/stable';
import 'regenerator-runtime/runtime';
import elementClosest from 'element-closest';
import objectFitImages from 'object-fit-images';
import 'whatwg-fetch';

//Vendors
// import 'bootstrap/js/dist/modal';
// import 'bootstrap/js/dist/tab';
// import 'bootstrap/js/dist/dropdown';
// import 'bootstrap/js/dist/tooltip';
// import 'bootstrap/js/dist/popover';
// import 'bootstrap/js/dist/scrollspy';
// import 'bootstrap/js/dist/toast';
// import 'bootstrap/js/dist/alert';
// import 'bootstrap/js/dist/util';
// import 'bootstrap/js/dist/button';
require('fslightbox');
const rater = require('rater-js');

import Likely from 'ilyabirman-likely';

//Next modules
import Nx from './next/Nx';
import './next/NxDynamicFormLabel';
import './next/NxMenu';
import './next/NxPhoneMask';
import './next/NxTabs';
import './next/NxRequest';
import './next/nxSerializefiles';

//Next initialize plugins
import AutoSizeTextarea from './plugins/AutoSizeTextarea';
import GalSlider from './plugins/GalSlider';
import ListSlider from './plugins/ListSlider';
import NumberAnimate from './plugins/NumberAnimate';
import PromoSlider from './plugins/PromoSlider';
import ScrollbarCustom from './plugins/ScrollbarCustom';
import SelectCustom from './plugins/SelectCustom';
import TabsSlider from './plugins/TabsSlider';
import CommonSlider from './plugins/CommonSlider';
import UploadField from './plugins/UploadField';
import RangeSlider from './plugins/RangeSlider';
import DatePicker from './plugins/DatePicker';
import Tabs from './plugins/Tabs';
import Modal from './plugins/Modal';
import Rating from './plugins/Rating';
import HandyCollapseWrapper from './plugins/HandyCollapseWrapper';

//Custom modules
import AttachDragger from './modules/AttachDragger';
import Search from './modules/Search';
import Affix from './modules/Affix';
import Video from './modules/Video';
import ShowMore from './modules/ShowMore';
import ShowModal from './modules/ShowModal';
import Ymaps from './modules/Ymaps';
import Filter from './modules/Filter';
import ScrollSection from './modules/ScrollSection';
import CartInformer from './modules/CartInformer';
import Cart from './modules/Cart';
import Counter from './modules/Counter';
import DeliveryTypeToggle from './modules/DeliveryTypeToggle';
import MapToggle from './modules/MapToggle';
import PasswordToggle from './modules/PasswordToggle';
import CompareTable from './modules/CompareTable';
import CompareHead from './modules/CompareHead';
import CookiePolicyPopup from "./modules/CookiePolicyPopup";
import Animate from "./modules/Animate";
import HeaderFix from "./modules/HeaderFix";


    Likely.initiate();
objectFitImages();
elementClosest(window);

$.nx = new Nx();

const filter = new Filter();

$.nx.addPlugin([
    new AutoSizeTextarea(),
    new GalSlider(),
    new HandyCollapseWrapper(),
    new ListSlider(),
    new DatePicker(),
    new PromoSlider(),
    new UploadField(),
    new ScrollbarCustom(),
    new SelectCustom(),
    new TabsSlider(),
    new RangeSlider(filter),
    new CommonSlider(),
    new Tabs(),
    new Modal(),
    new Rating(rater),
]);

new Ymaps();

new NumberAnimate();
new Affix();
new AttachDragger();
new PasswordToggle();
new Search();
new DeliveryTypeToggle();
new ShowModal();
const cartInformer = new CartInformer();
const cart = new Cart(cartInformer);
new Counter(cart);
new MapToggle();
new ScrollSection();
new Video();
new ShowMore();
new CompareTable();
new CompareHead();
new CookiePolicyPopup();
new Animate();
new HeaderFix();
