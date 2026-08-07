--
-- PostgreSQL database dump
--

-- \restrict removed (causes psql failures in non-interactive mode)

-- Dumped from database version 17.10
-- Dumped by pg_dump version 17.10

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- Name: cart_items; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cart_items (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    producto_id bigint NOT NULL,
    cantidad integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.cart_items OWNER TO postgres;

--
-- Name: cart_items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cart_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cart_items_id_seq OWNER TO postgres;

--
-- Name: cart_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cart_items_id_seq OWNED BY public.cart_items.id;


--
-- Name: categorias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categorias (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    activo boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.categorias OWNER TO postgres;

--
-- Name: categorias_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categorias_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categorias_id_seq OWNER TO postgres;

--
-- Name: categorias_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categorias_id_seq OWNED BY public.categorias.id;


--
-- Name: configuraciones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.configuraciones (
    id bigint NOT NULL,
    nombre_negocio character varying(255) DEFAULT 'Pañalera'::character varying NOT NULL,
    descripcion text,
    direccion text,
    telefono character varying(255),
    email character varying(255),
    whatsapp character varying(255),
    instagram character varying(255),
    facebook character varying(255),
    horarios character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.configuraciones OWNER TO postgres;

--
-- Name: configuraciones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.configuraciones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.configuraciones_id_seq OWNER TO postgres;

--
-- Name: configuraciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.configuraciones_id_seq OWNED BY public.configuraciones.id;


--
-- Name: etapas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.etapas (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    activo boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.etapas OWNER TO postgres;

--
-- Name: etapas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.etapas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.etapas_id_seq OWNER TO postgres;

--
-- Name: etapas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.etapas_id_seq OWNED BY public.etapas.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: marcas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.marcas (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    activo boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    imagen character varying(255)
);


ALTER TABLE public.marcas OWNER TO postgres;

--
-- Name: marcas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.marcas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.marcas_id_seq OWNER TO postgres;

--
-- Name: marcas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.marcas_id_seq OWNED BY public.marcas.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: pedido_items; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedido_items (
    id bigint NOT NULL,
    pedido_id bigint NOT NULL,
    producto_id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    cantidad integer NOT NULL,
    precio_unitario numeric(10,2) NOT NULL,
    subtotal numeric(10,2) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.pedido_items OWNER TO postgres;

--
-- Name: pedido_items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedido_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pedido_items_id_seq OWNER TO postgres;

--
-- Name: pedido_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedido_items_id_seq OWNED BY public.pedido_items.id;


--
-- Name: pedidos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedidos (
    id bigint NOT NULL,
    user_id bigint,
    total numeric(10,2) NOT NULL,
    subtotal numeric(10,2) NOT NULL,
    descuento numeric(10,2) DEFAULT '0'::numeric NOT NULL,
    estado character varying(255) DEFAULT 'pendiente'::character varying NOT NULL,
    direccion character varying(255),
    ciudad character varying(255),
    codigo_postal character varying(255),
    telefono character varying(255),
    observaciones text,
    mp_preference_id character varying(255),
    mp_payment_id character varying(255),
    mp_status character varying(255),
    mp_merchant_order_id character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    token character varying(64),
    email character varying(255),
    mp_qr_data text,
    mp_order_id character varying(255)
);


ALTER TABLE public.pedidos OWNER TO postgres;

--
-- Name: pedidos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedidos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pedidos_id_seq OWNER TO postgres;

--
-- Name: pedidos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedidos_id_seq OWNED BY public.pedidos.id;


--
-- Name: producto_imagens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.producto_imagens (
    id bigint NOT NULL,
    producto_id bigint NOT NULL,
    path character varying(255) NOT NULL,
    es_principal boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.producto_imagens OWNER TO postgres;

--
-- Name: producto_imagens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.producto_imagens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.producto_imagens_id_seq OWNER TO postgres;

--
-- Name: producto_imagens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.producto_imagens_id_seq OWNED BY public.producto_imagens.id;


--
-- Name: productos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.productos (
    id bigint NOT NULL,
    categoria_id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    descripcion text,
    precio numeric(10,2) NOT NULL,
    stock integer DEFAULT 0 NOT NULL,
    edad_talla text,
    activo boolean DEFAULT true NOT NULL,
    destacado boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    marca_id bigint,
    etapa_id bigint,
    tiene_talla boolean DEFAULT false NOT NULL
);


ALTER TABLE public.productos OWNER TO postgres;

--
-- Name: productos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.productos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.productos_id_seq OWNER TO postgres;

--
-- Name: productos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.productos_id_seq OWNED BY public.productos.id;


--
-- Name: promocion_producto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.promocion_producto (
    id bigint NOT NULL,
    promocion_id bigint NOT NULL,
    producto_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.promocion_producto OWNER TO postgres;

--
-- Name: promocion_producto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.promocion_producto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.promocion_producto_id_seq OWNER TO postgres;

--
-- Name: promocion_producto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.promocion_producto_id_seq OWNED BY public.promocion_producto.id;


--
-- Name: promociones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.promociones (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    descripcion text,
    tipo_descuento character varying(255) DEFAULT 'porcentaje'::character varying NOT NULL,
    valor_descuento numeric(10,2) NOT NULL,
    fecha_inicio date NOT NULL,
    fecha_fin date NOT NULL,
    activo boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT promociones_tipo_descuento_check CHECK (((tipo_descuento)::text = ANY ((ARRAY['porcentaje'::character varying, 'fijo'::character varying])::text[])))
);


ALTER TABLE public.promociones OWNER TO postgres;

--
-- Name: promociones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.promociones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.promociones_id_seq OWNER TO postgres;

--
-- Name: promociones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.promociones_id_seq OWNED BY public.promociones.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    direccion character varying(255),
    telefono character varying(255),
    is_admin boolean DEFAULT false NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: cart_items id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_items ALTER COLUMN id SET DEFAULT nextval('public.cart_items_id_seq'::regclass);


--
-- Name: categorias id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorias ALTER COLUMN id SET DEFAULT nextval('public.categorias_id_seq'::regclass);


--
-- Name: configuraciones id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.configuraciones ALTER COLUMN id SET DEFAULT nextval('public.configuraciones_id_seq'::regclass);


--
-- Name: etapas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etapas ALTER COLUMN id SET DEFAULT nextval('public.etapas_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: marcas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.marcas ALTER COLUMN id SET DEFAULT nextval('public.marcas_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: pedido_items id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_items ALTER COLUMN id SET DEFAULT nextval('public.pedido_items_id_seq'::regclass);


--
-- Name: pedidos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos ALTER COLUMN id SET DEFAULT nextval('public.pedidos_id_seq'::regclass);


--
-- Name: producto_imagens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_imagens ALTER COLUMN id SET DEFAULT nextval('public.producto_imagens_id_seq'::regclass);


--
-- Name: productos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos ALTER COLUMN id SET DEFAULT nextval('public.productos_id_seq'::regclass);


--
-- Name: promocion_producto id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promocion_producto ALTER COLUMN id SET DEFAULT nextval('public.promocion_producto_id_seq'::regclass);


--
-- Name: promociones id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promociones ALTER COLUMN id SET DEFAULT nextval('public.promociones_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer	i:1783791378;	1783791378
laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6	i:1;	1783791378
laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer	i:1786051362;	1786051362
laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab	i:4;	1786051362
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: cart_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cart_items (id, user_id, producto_id, cantidad, created_at, updated_at) FROM stdin;
19	8	2	1	2026-08-03 21:18:43	2026-08-03 21:18:43
\.


--
-- Data for Name: categorias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categorias (id, nombre, activo, created_at, updated_at) FROM stdin;
1	Pañales	t	2026-07-06 20:45:02	2026-07-06 20:45:02
2	Ropa	t	2026-07-06 20:45:02	2026-07-06 20:45:02
3	Higiene	t	2026-07-06 20:45:02	2026-07-06 20:45:02
4	Alimentación	t	2026-07-06 20:45:02	2026-07-06 20:45:02
5	Accesorios	t	2026-07-06 20:45:02	2026-07-06 20:45:02
\.


--
-- Data for Name: configuraciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.configuraciones (id, nombre_negocio, descripcion, direccion, telefono, email, whatsapp, instagram, facebook, horarios, created_at, updated_at) FROM stdin;
1	Adolfina	Tu tienda de confianza para el cuidado de tu bebé. Pañales, ropa, higiene y más.	\N	\N	cristianmarsico84@gmail.com	541112345678	https://www.google.com	https://www.google.com	de 8 a 21	2026-07-06 20:45:02	2026-08-06 21:32:17
\.


--
-- Data for Name: etapas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.etapas (id, nombre, activo, created_at, updated_at) FROM stdin;
9	Adulto	t	2026-07-09 18:54:14	2026-07-09 18:54:14
8	Niño	t	2026-07-09 18:54:01	2026-07-09 18:54:35
7	Bebé	t	2026-07-09 18:53:51	2026-07-09 18:54:41
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: marcas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.marcas (id, nombre, activo, created_at, updated_at, imagen) FROM stdin;
1	Huggies	t	2026-07-06 20:45:02	2026-08-06 21:21:45	marcas/01KZCF8814BTQ78NNPZ977KBNG.png
2	Pampers	t	2026-07-06 20:45:02	2026-08-06 21:22:01	marcas/01KZCF8QERXX7GQWSTZ0RX0GJB.jpg
3	Babysec	t	2026-07-06 20:45:02	2026-08-06 21:22:21	marcas/01KZCF9B2J3RXM0527BE5T0WV6.jpg
4	Pequeño Mundo	t	2026-07-06 20:45:02	2026-08-06 21:22:41	marcas/01KZCF9YKV4XK97J1F9CAFNRSF.jpg
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_07_05_213447_create_categorias_table	1
5	2026_07_05_213449_create_productos_table	1
6	2026_07_05_213450_create_producto_imagens_table	1
7	2026_07_05_213451_create_producto_atributos_table	1
8	2026_07_05_225158_create_promociones_table	1
9	2026_07_05_225159_create_promocion_producto_table	1
10	2026_07_05_233916_create_pedidos_table	1
11	2026_07_05_233917_create_pedido_items_table	1
12	2026_07_06_000327_add_direccion_and_telefono_to_users_table	1
13	2026_07_06_001633_add_is_admin_to_users_table	1
14	2026_07_06_001723_create_talles_table	1
15	2026_07_06_012815_remove_slug_descripcion_padre_id_from_categorias	1
16	2026_07_06_014542_remove_orden_from_producto_imagens	1
17	2026_07_06_015920_remove_slug_from_promociones	1
18	2026_07_06_020000_create_configuraciones_table	1
19	2026_07_06_203117_drop_orden_from_talles_table	1
20	2026_07_06_204102_create_marcas_table	1
21	2026_07_06_204124_alter_productos_add_marca_id_drop_marca_slug	1
22	2026_07_06_211110_add_tiene_talles_to_productos_table	2
23	2026_07_06_212000_add_unique_constraint_to_producto_talle	3
24	2026_07_06_213000_create_etapas_table	4
25	2026_07_06_220000_create_cart_items_table	5
26	2026_07_06_230000_add_token_to_pedidos_table	6
27	2026_07_06_235000_modify_user_id_nullable_add_email_to_pedidos	7
28	2026_07_08_220418_add_atributo_id_to_pedido_items_table	8
29	2026_07_09_145525_add_imagen_to_marcas_table	9
30	2026_07_09_170940_drop_talles_tables	10
31	2026_07_09_173934_add_tiene_talla_to_productos_table	11
32	2026_08_03_211514_remove_atributos	12
33	2026_07_05_000001_create_categorias_table	13
34	2026_07_05_000002_create_marcas_table	13
35	2026_07_05_000003_create_etapas_table	13
36	2026_07_05_000004_create_productos_table	13
37	2026_07_05_000005_create_producto_relations_table	13
38	2026_07_05_000006_create_promociones_table	13
39	2026_07_05_000007_create_pedidos_table	13
40	2026_07_05_000008_create_cart_and_config_table	13
41	2026_08_06_223625_add_mp_qr_fields_to_pedidos_table	14
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: pedido_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pedido_items (id, pedido_id, producto_id, nombre, cantidad, precio_unitario, subtotal, created_at, updated_at) FROM stdin;
28	21	2	Pañales Pampers Premium Care M x48	1	9200.00	9200.00	2026-08-03 21:46:35	2026-08-03 21:46:35
29	22	23	sdfdsff	1	34.00	34.00	2026-08-06 22:43:16	2026-08-06 22:43:16
30	23	15	Enterito polar con capucha	1	9800.00	9800.00	2026-08-06 22:46:18	2026-08-06 22:46:18
31	23	14	Body manga corta x3	1	5500.00	5500.00	2026-08-06 22:46:18	2026-08-06 22:46:18
32	24	16	Crema para pañal Mustela 100ml	1	6200.00	6200.00	2026-08-06 22:50:31	2026-08-06 22:50:31
33	24	18	Leche NAN 1 polvo 800g	1	14500.00	14500.00	2026-08-06 22:50:31	2026-08-06 22:50:31
34	25	19	Papilla Nestum Multicereal 200g	1	3200.00	3200.00	2026-08-06 22:52:40	2026-08-06 22:52:40
36	27	17	Shampoo + jabón líquido Johnson Baby 500ml	1	4100.00	4100.00	2026-08-06 23:22:10	2026-08-06 23:22:10
37	27	16	Crema para pañal Mustela 100ml	1	6200.00	6200.00	2026-08-06 23:22:10	2026-08-06 23:22:10
38	28	11	Pañales Huggies Supreme RN x50	2	8500.00	17000.00	2026-08-06 23:35:28	2026-08-06 23:35:28
39	29	18	Leche NAN 1 polvo 800g	1	14500.00	14500.00	2026-08-07 00:10:34	2026-08-07 00:10:34
40	29	4	Body manga corta x3	1	5500.00	5500.00	2026-08-07 00:10:34	2026-08-07 00:10:34
41	30	15	Enterito polar con capucha	1	9800.00	9800.00	2026-08-07 00:14:03	2026-08-07 00:14:03
42	31	18	Leche NAN 1 polvo 800g	8	14500.00	116000.00	2026-08-07 00:17:51	2026-08-07 00:17:51
\.


--
-- Data for Name: pedidos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pedidos (id, user_id, total, subtotal, descuento, estado, direccion, ciudad, codigo_postal, telefono, observaciones, mp_preference_id, mp_payment_id, mp_status, mp_merchant_order_id, created_at, updated_at, token, email, mp_qr_data, mp_order_id) FROM stdin;
21	9	9200.00	9200.00	0.00	pagado	Calle 1	Rosario	2000	3410000000	\N	TEST_21_1785793595	TEST_21	approved	\N	2026-08-03 21:46:35	2026-08-03 21:46:35	Xk9ghgWtWkm5B0eDHIrgQrtPGYZOxbRy	co.53509@test.local	\N	\N
22	\N	34.00	34.00	0.00	pagado	Calle 1 100	Buenos Aires	1425	1111111111	\N	\N	TEST_22	approved	\N	2026-08-06 22:43:15	2026-08-06 22:43:41	eKfjkRV4TEn0NvFyG0aCpPOU0efmeUgY	qa@test.com	TEST_QR_22_1786056196	TEST_ORDER_22_1786056196
23	\N	15300.00	15300.00	0.00	pagado	Las heras 219	Lobería	7635	02262570382	\N	\N	TEST_23	approved	\N	2026-08-06 22:46:18	2026-08-06 22:49:24	3fzXVRr9pUF5F3jILZRVfPTmda1qJOqh	cristianmarsico84@gmail.com	TEST_QR_23_1786056378	TEST_ORDER_23_1786056378
24	4	20700.00	20700.00	0.00	pagado	Gregorio's Italian Restaurant	Carlsbad	92008	02243242432	\N	\N	TEST_24	approved	\N	2026-08-06 22:50:31	2026-08-06 22:50:36	BNyj4WzAxEOU3VhbIBzth5sfGUVXhl8x	sergio@gmail.com	TEST_QR_24_1786056631	TEST_ORDER_24_1786056631
25	4	3200.00	3200.00	0.00	pagado	Gregorio's Italian Restaurant	Carlsbad	92008	344234234324	\N	\N	TEST_25	approved	\N	2026-08-06 22:52:40	2026-08-06 22:52:53	6l5SLm4Zks2hcfUWo3TAU4GYjXvzKbZK	sergio@gmail.com	TEST_QR_25_1786056760	TEST_ORDER_25_1786056760
29	4	20000.00	20000.00	0.00	pagado	Gregorio's Italian Restaurant	Carlsbad	92008	02226625709	\N	\N	TEST_29	approved	\N	2026-08-07 00:10:34	2026-08-07 00:11:54	jdR6cQZU8lDYlCChAU7vFVGIxfIJmgeb	sergio@gmail.com	00020101021243650016com.mercadolibre020130636bad92398-4dfa-4285-8495-89c7f33182c25011000711111115204970053030325802AR5909Test Test6004CABA63041D83	ORDTST01KZCRXCEED1CBZNY2PRF195FT
30	4	9800.00	9800.00	0.00	pagado	Gregorio's Italian Restaurant	Carlsbad	92008	5665565	\N	\N	TEST_30	approved	\N	2026-08-07 00:14:03	2026-08-07 00:14:18	OYZWUSNeCkq8195294D0BzbQCRct28m0	sergio@gmail.com	00020101021243650016com.mercadolibre0201306360940f13b-33af-4a5b-a5ca-d8d3d02677ec5011000711111115204970053030325802AR5909Test Test6004CABA63044B66	ORDTST01KZCS3RHYJHYKFAQ272Z5AYGN
31	4	116000.00	116000.00	0.00	pagado	Gregorio's Italian Restaurant	Carlsbad	92008	565656556	\N	\N	TEST_31	approved	\N	2026-08-07 00:17:51	2026-08-07 00:19:53	hsqknZrYatKexPKsVq0NJTzsBJT9cj49	sergio@gmail.com	00020101021243650016com.mercadolibre020130636e010a812-bd91-4553-9a80-59ead38c21125011000711111115204970053030325802AR5909Test Test6004CABA630460B1	ORDTST01KZCSAQ8MZ6PS01DV00R2JJMC
27	4	10300.00	10300.00	0.00	pagado	Gregorio's Italian Restaurant	Carlsbad	92008	32432432432	\N	\N	171547941599	approved	ORDTST01KZCP4RKHV9Z4B35R3P44TW53	2026-08-06 23:22:10	2026-08-07 00:22:56	2lSqK6luHlv6KKam4SiAS3ubP8qkwn1y	sergio@gmail.com	00020101021243650016com.mercadolibre0201306366c46fe5b-9e28-48b1-b607-79bf0b3633bd5011000711111115204970053030325802AR5909Test Test6004CABA630452DB	ORDTST01KZCP4RKHV9Z4B35R3P44TW53
28	4	17000.00	17000.00	0.00	pagado	Gregorio's Italian Restaurant	Loberia	92008	295656	\N	\N	171550886599	approved	ORDTST01KZCPX3RF27KKYZAYW4D40HCZ	2026-08-06 23:35:28	2026-08-07 00:22:56	UXAnTz84FD4vrtre5mRAp7I3EHz42NPm	sergio@gmail.com	00020101021243650016com.mercadolibre0201306360fb68729-955f-44c8-af21-34fa6983b2d05011000711111115204970053030325802AR5909Test Test6004CABA63040C9A	ORDTST01KZCPX3RF27KKYZAYW4D40HCZ
\.


--
-- Data for Name: producto_imagens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.producto_imagens (id, producto_id, path, es_principal, created_at, updated_at) FROM stdin;
1	1	productos/01KX3X92G03CG080CKZ75M0K7A.jpeg	t	2026-07-09 17:02:19	2026-07-09 17:02:19
3	1	productos/01KX3XBSCPKFWDQVZZGFJNJGNK.jpeg	f	2026-07-09 17:03:48	2026-07-09 17:03:48
4	1	productos/01KX3XDK6TVV4YW88ZWAV28GV2.jpeg	f	2026-07-09 17:04:47	2026-07-09 17:04:47
\.


--
-- Data for Name: productos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.productos (id, categoria_id, nombre, descripcion, precio, stock, edad_talla, activo, destacado, created_at, updated_at, marca_id, etapa_id, tiene_talla) FROM stdin;
9	4	Papilla Nestum Multicereal 200g	Papilla de multicereal fortificada con vitaminas y minerales.	3200.00	90	6+ meses	t	f	2026-07-06 20:45:02	2026-07-06 21:38:06	\N	\N	f
1	1	Pañales Huggies Supreme RN x50	<p>Pañales descartables Huggies Supreme para recién nacido. Suaves y con protección total.</p>	8500.00	100	RN (2-5 kg)	t	t	2026-07-06 20:45:02	2026-08-03 21:00:51	1	7	t
2	1	Pañales Pampers Premium Care M x48	Pañales Pampers Premium Care, talla mediana. Máxima absorción y sequedad.	9200.00	79	M (6-11 kg)	t	t	2026-07-06 20:45:02	2026-08-03 21:46:35	2	\N	f
3	1	Pañales Babysec G x42	<p>Pañales Babysec talla grande, con barreras anti-filtraje y ajuste elástico.</p>	7800.00	60	G (9-14 kg)	t	f	2026-07-06 20:45:02	2026-08-04 19:18:57	3	7	f
13	1	Pañales Babysec G x42	<p>Pañales Babysec talla grande, con barreras anti-filtraje y ajuste elástico.</p>	7800.00	60	G (9-14 kg)	t	f	2026-07-06 20:51:22	2026-08-04 19:19:34	3	9	f
4	2	Body manga corta x3	Pack de 3 bodies de algodón manga corta, ideal para el día a día.	5500.00	39	RN - 12 meses	t	t	2026-07-06 20:45:02	2026-08-07 00:11:54	4	\N	f
23	5	sdfdsff	<p>sdfsfsdfdsf</p>	34.00	33	XXG	t	f	2026-08-03 21:06:35	2026-08-06 22:43:41	3	9	t
14	2	Body manga corta x3	Pack de 3 bodies de algodón manga corta, ideal para el día a día.	5500.00	39	RN - 12 meses	t	t	2026-07-06 20:51:23	2026-08-06 22:49:24	4	\N	f
19	4	Papilla Nestum Multicereal 200g	Papilla de multicereal fortificada con vitaminas y minerales.	3200.00	89	6+ meses	t	f	2026-07-06 20:51:23	2026-08-06 22:52:53	\N	\N	f
17	3	Shampoo + jabón líquido Johnson Baby 500ml	Shampoo y jabón 2 en 1, fórmula suave sin lágrimas.	4100.00	69	\N	t	f	2026-07-06 20:51:23	2026-08-06 23:23:53	\N	\N	f
5	2	Enterito polar con capucha	Enterito de polar suave con capucha, perfecto para el invierno.	9800.00	30	6-18 meses	t	f	2026-07-06 20:45:02	2026-07-06 21:38:06	4	\N	f
12	1	Pañales Pampers Premium Care M x48	Pañales Pampers Premium Care, talla mediana. Máxima absorción y sequedad.	9200.00	80	M (6-11 kg)	t	t	2026-07-06 20:51:22	2026-07-06 21:38:06	2	\N	f
8	4	Leche NAN 1 polvo 800g	Leche en polvo para lactantes desde el primer día.	14500.00	40	0-6 meses	t	t	2026-07-06 20:45:02	2026-07-06 21:38:06	\N	\N	f
10	5	Chupete ortodóntico silicona 0-6m x2	Chupete de silicona ortodóntico con protector nasal. Pack x2.	2800.00	100	\N	t	f	2026-07-06 20:45:02	2026-07-06 21:38:06	\N	\N	f
20	5	Chupete ortodóntico silicona 0-6m x2	Chupete de silicona ortodóntico con protector nasal. Pack x2.	2800.00	100	\N	t	f	2026-07-06 20:51:23	2026-07-06 21:38:06	\N	\N	f
6	3	Crema para pañal Mustela 100ml	Crema protectora para la zona del pañal, previene y trata la irritación.	6200.00	50	\N	t	t	2026-07-06 20:45:02	2026-07-06 21:38:06	\N	\N	f
7	3	Shampoo + jabón líquido Johnson Baby 500ml	Shampoo y jabón 2 en 1, fórmula suave sin lágrimas.	4100.00	70	\N	t	f	2026-07-06 20:45:02	2026-07-06 21:38:06	\N	\N	f
16	3	Crema para pañal Mustela 100ml	Crema protectora para la zona del pañal, previene y trata la irritación.	6200.00	48	\N	t	t	2026-07-06 20:51:23	2026-08-06 23:23:53	\N	\N	f
11	1	Pañales Huggies Supreme RN x50	Pañales descartables Huggies Supreme para recién nacido. Suaves y con protección total.	8500.00	98	RN (2-5 kg)	t	t	2026-07-06 20:51:22	2026-08-06 23:36:49	1	\N	f
15	2	Enterito polar con capucha	Enterito de polar suave con capucha, perfecto para el invierno.	9800.00	28	6-18 meses	t	f	2026-07-06 20:51:23	2026-08-07 00:14:18	4	\N	f
18	4	Leche NAN 1 polvo 800g	Leche en polvo para lactantes desde el primer día.	14500.00	30	0-6 meses	t	t	2026-07-06 20:51:23	2026-08-07 00:19:53	\N	\N	f
\.


--
-- Data for Name: promocion_producto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.promocion_producto (id, promocion_id, producto_id, created_at, updated_at) FROM stdin;
5	4	2	\N	\N
6	4	10	\N	\N
7	4	11	\N	\N
8	4	13	\N	\N
9	4	4	\N	\N
10	4	7	\N	\N
\.


--
-- Data for Name: promociones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.promociones (id, nombre, descripcion, tipo_descuento, valor_descuento, fecha_inicio, fecha_fin, activo, created_at, updated_at) FROM stdin;
4	Dia del bebé	\N	porcentaje	30.00	2026-08-03	2026-08-05	t	2026-08-03 22:31:15	2026-08-03 22:31:15
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
n0oqZ3yW990b6oShz5aFD7hhXWFRM4TA5lWTMb6A	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YToyOntzOjY6Il90b2tlbiI7czo0MDoiN1pnOFA1MjhZdTlmSkt0U3BMWHhOU2JlNEd2OWR0R0hpN245a1NudyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1786064868
UgSkk2oZIEtJKVPgEJqzPLR8qqgqTu5OmQR1LmYx	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YToyOntzOjY6Il90b2tlbiI7czo0MDoieVNxQUZtZ2h6YTMwaVN6aDNyd1F4bU5GSUo3cU1LWUhhRjUyVkU4QSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1786064999
OrtGHgrD56qqZI2rdDBcCPmDrIjBp4yO2F5KbYZ3	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YTozOntzOjY6Il90b2tlbiI7czo0MDoiM1FJTkJXd2Y0STBoZ3FkWW8yRzBWc1hPZkxUUVVxa2llNjBPRUtjdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Nzk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jaGVja291dC8zMy9lc3RhZG8/dG9rZW49NzU4ODVGUXAwTVBYUVROc1NiZnNncG9XaVJoS3hWMEUiO3M6NToicm91dGUiO3M6MTU6ImNoZWNrb3V0LmVzdGFkbyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=	1786065015
EsTTd7MW466oQcBiJNkiRsH1rRqWdlhFpxIXqxQO	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YTo0OntzOjY6Il90b2tlbiI7czo0MDoicURLa3QzU2JpMk9mVXBDZnZKcVhydVJvQkJhV2hod1JySmJSVkdCbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo0OiJjYXJ0IjthOjE6e2k6NDthOjQ6e3M6MTE6InByb2R1Y3RvX2lkIjtpOjQ7czo2OiJub21icmUiO3M6MTk6IkJvZHkgbWFuZ2EgY29ydGEgeDMiO3M6NjoicHJlY2lvIjtkOjU1MDA7czo4OiJjYW50aWRhZCI7aToxO319fQ==	1786062187
xEYpzzFwWqXB6OQzsfAGrzvOjXXVFyjUDIYcvBwF	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YTozOntzOjY6Il90b2tlbiI7czo0MDoidWVkTWdCaDc1MDNabWRTSWRwN21MN2VIVE5TMXNLakxJVHR0QWlRSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1786058407
tMwHHMZ1UDXbvkAfBzdBuojoGJHktJLmV2sPC5FO	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YTozOntzOjY6Il90b2tlbiI7czo0MDoiRU5PakIzSTlpOE5XWDg4c3dncjJSTmtoUm42a1JrWHo2T1BpUU9LeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Nzk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jaGVja291dC8yNi9lc3RhZG8/dG9rZW49cjVmVzlDWVJ5c0xNNEx5dTE5RWdzOENSOW9xZjJ3b3AiO3M6NToicm91dGUiO3M6MTU6ImNoZWNrb3V0LmVzdGFkbyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=	1786058443
eiZ6mYAmofImAf1nLoMsKvTFcbW47N4MZaRycRkH	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YTozOntzOjY6Il90b2tlbiI7czo0MDoieFdtVDVZME0zREJnd0dRYVp3SFZicjBVS1FOWFFsQm01UFdMS3ZuNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Nzk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jaGVja291dC8zMi9lc3RhZG8/dG9rZW49ZmdPYk5pTkI0N3pRdG5YdXhnTVcyQnNZR3RhcDczRVIiO3M6NToicm91dGUiO3M6MTU6ImNoZWNrb3V0LmVzdGFkbyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=	1786062189
mhtoTtYqxbOUTkXz8JioSQO3zkZyn06cpAp6RGTI	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YToyOntzOjY6Il90b2tlbiI7czo0MDoiNHhyelR4M3I4bzdxelZTZEJnZEtrWkgxOUk4UnhUVGZnTDFDY0tHOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1786064868
1kUfSaCcOF9uYEqQo1OAm5XHU4cB8nXv4c92pnoC	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YToyOntzOjY6Il90b2tlbiI7czo0MDoiVDNva3pTbUs1VXNJSmpISlF6U1R0M2lBRERXTFRZWHV2QkRpckN3USI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1786064999
oQzvpWzx5Mp3UzLFOSS6zd6JFIsNYBRnFsjmNp5B	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YTozOntzOjY6Il90b2tlbiI7czo0MDoiNE9SZjlydzNXS1l6QU1BdlFUY25qUEJZTllQellUZU9iRng5eWlaSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1786058420
Pr5fN2sko6YAwTFBQjMeEczi4Ex29RyX2EBpU1VE	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YTo0OntzOjY6Il90b2tlbiI7czo0MDoibGw0S3NJS2Zrek9KTENuajRXUjdCdGFTNkoxWU9ud2lQY0JmZWg2RSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo0OiJjYXJ0IjthOjE6e2k6NDthOjQ6e3M6MTE6InByb2R1Y3RvX2lkIjtpOjQ7czo2OiJub21icmUiO3M6MTk6IkJvZHkgbWFuZ2EgY29ydGEgeDMiO3M6NjoicHJlY2lvIjtkOjU1MDA7czo4OiJjYW50aWRhZCI7aToxO319fQ==	1786058434
dyY1BnOfuStvEIlsrRGCZXOd8ODuxRhg7o3NIfi4	4	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaU9DOWxZek55djVaZW81NUVBNEZkZUFYbW9sQjRPR1lMSDB5TWJWOCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvcHJvZHVjdG9zLzE4L3ByZWNpbyI7czo1OiJyb3V0ZSI7czoyMDoiYXBpLnByb2R1Y3Rvcy5wcmVjaW8iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=	1786064761
8vlJ8hfhWRsDlyQAQhwvJTKWh0e2KrodxPVlcTVt	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YToyOntzOjY6Il90b2tlbiI7czo0MDoiN2x6bkVyN3IwTklHZTBPekEzU1RsaUp5SGsxbWxhY0liSjZBRk9tViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1786064906
mZ5xzUcXnPxi8ewBFnrnRBzwQei5oasboAUQo7Sw	\N	127.0.0.1	Mozilla/5.0 (Windows NT; Windows NT 10.0; es-AR) WindowsPowerShell/5.1.26100.8875	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV2lnUkZyVXBFVGl3MmZ5dWs5bE9PWnBVY0pIVWJHVW9vRWd1OUJOayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo0OiJjYXJ0IjthOjE6e2k6NDthOjQ6e3M6MTE6InByb2R1Y3RvX2lkIjtpOjQ7czo2OiJub21icmUiO3M6MTk6IkJvZHkgbWFuZ2EgY29ydGEgeDMiO3M6NjoicHJlY2lvIjtkOjU1MDA7czo4OiJjYW50aWRhZCI7aToxO319fQ==	1786065013
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, direccion, telefono, is_admin) FROM stdin;
2	cristian	cristian@gmail.com	\N	$2y$12$kb9pcl79LhfFwd.50eAsUejm2OodPZHeMTzt/o.s50iIurESJc/4a	\N	2026-07-06 22:13:48	2026-07-06 22:13:48	\N	\N	f
4	sergio	sergio@gmail.com	\N	$2y$12$PdYiCwSJ7pd3GeYupECr7OMXc4iyjsbUNbR9rrO5DjV.yXnybbsuS	\N	2026-07-08 22:46:09	2026-07-08 22:46:09	\N	\N	f
1	Admin	admin@panalera.com	\N	$2y$12$rQsAW5vf3vacpdvyOPJSJegMrrcSq9UwcE7vJMKQ4d8.Z2yzyQQqi	\N	2026-07-06 20:45:02	2026-08-03 19:49:48	\N	\N	t
5	Usuario Prueba	prueba.39519@test.local	\N	$2y$12$WegCzi7oRXUTdQfIkUv9eOfwHg3cO6EI4dc.Eb/lbDkocy81FcZSy	\N	2026-08-03 20:47:05	2026-08-03 20:47:05	\N	\N	f
6	Usuario Prueba	prueba.71611@test.local	\N	$2y$12$rtPPz60Psrh6bEWCDPyvEeLtuWSvTJ8qiQhKGRmXq/R0nntK//UBm	\N	2026-08-03 20:47:20	2026-08-03 20:47:20	\N	\N	f
7	Usuario Prueba	prueba.62840@test.local	\N	$2y$12$uWoXidfK0cYv0kNBXYpOmOoqi6bdUXAFDJBNwITOgXepQ7v.KKvTC	\N	2026-08-03 20:47:31	2026-08-03 20:47:31	\N	\N	f
8	Compra Prueba	compra.45440@test.local	\N	$2y$12$Iwg6Yjy9U2YBlMzYGETgTeGFSnfP1OCTDb42UxMJiCHLHKloqWg4K	\N	2026-08-03 21:18:43	2026-08-03 21:18:43	\N	\N	f
9	Co Prueba	co.53509@test.local	\N	$2y$12$npW3UzTI0CXwf2yBVvP3gOx3pLOtKyasvrokv2RukkntoYacAPhxu	\N	2026-08-03 21:46:34	2026-08-03 21:46:34	\N	\N	f
\.


--
-- Name: cart_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cart_items_id_seq', 30, true);


--
-- Name: categorias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categorias_id_seq', 20, true);


--
-- Name: configuraciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.configuraciones_id_seq', 1, true);


--
-- Name: etapas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.etapas_id_seq', 9, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: marcas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.marcas_id_seq', 17, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 41, true);


--
-- Name: pedido_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedido_items_id_seq', 44, true);


--
-- Name: pedidos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedidos_id_seq', 33, true);


--
-- Name: producto_imagens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.producto_imagens_id_seq', 4, true);


--
-- Name: productos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.productos_id_seq', 23, true);


--
-- Name: promocion_producto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.promocion_producto_id_seq', 10, true);


--
-- Name: promociones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.promociones_id_seq', 4, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 9, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: cart_items cart_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_items
    ADD CONSTRAINT cart_items_pkey PRIMARY KEY (id);


--
-- Name: cart_items cart_items_user_id_producto_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_items
    ADD CONSTRAINT cart_items_user_id_producto_id_unique UNIQUE (user_id, producto_id);


--
-- Name: categorias categorias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_pkey PRIMARY KEY (id);


--
-- Name: configuraciones configuraciones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.configuraciones
    ADD CONSTRAINT configuraciones_pkey PRIMARY KEY (id);


--
-- Name: etapas etapas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etapas
    ADD CONSTRAINT etapas_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: marcas marcas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.marcas
    ADD CONSTRAINT marcas_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: pedido_items pedido_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_items
    ADD CONSTRAINT pedido_items_pkey PRIMARY KEY (id);


--
-- Name: pedidos pedidos_mp_preference_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_mp_preference_id_unique UNIQUE (mp_preference_id);


--
-- Name: pedidos pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id);


--
-- Name: pedidos pedidos_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_token_unique UNIQUE (token);


--
-- Name: producto_imagens producto_imagens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_imagens
    ADD CONSTRAINT producto_imagens_pkey PRIMARY KEY (id);


--
-- Name: productos productos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_pkey PRIMARY KEY (id);


--
-- Name: promocion_producto promocion_producto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promocion_producto
    ADD CONSTRAINT promocion_producto_pkey PRIMARY KEY (id);


--
-- Name: promocion_producto promocion_producto_promocion_id_producto_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promocion_producto
    ADD CONSTRAINT promocion_producto_promocion_id_producto_id_unique UNIQUE (promocion_id, producto_id);


--
-- Name: promociones promociones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promociones
    ADD CONSTRAINT promociones_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: cart_items cart_items_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_items
    ADD CONSTRAINT cart_items_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.productos(id) ON DELETE CASCADE;


--
-- Name: cart_items cart_items_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_items
    ADD CONSTRAINT cart_items_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: pedido_items pedido_items_pedido_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_items
    ADD CONSTRAINT pedido_items_pedido_id_foreign FOREIGN KEY (pedido_id) REFERENCES public.pedidos(id) ON DELETE CASCADE;


--
-- Name: pedido_items pedido_items_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_items
    ADD CONSTRAINT pedido_items_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.productos(id) ON DELETE CASCADE;


--
-- Name: pedidos pedidos_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: producto_imagens producto_imagens_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_imagens
    ADD CONSTRAINT producto_imagens_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.productos(id) ON DELETE CASCADE;


--
-- Name: productos productos_categoria_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_categoria_id_foreign FOREIGN KEY (categoria_id) REFERENCES public.categorias(id) ON DELETE CASCADE;


--
-- Name: productos productos_etapa_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_etapa_id_foreign FOREIGN KEY (etapa_id) REFERENCES public.etapas(id) ON DELETE SET NULL;


--
-- Name: productos productos_marca_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_marca_id_foreign FOREIGN KEY (marca_id) REFERENCES public.marcas(id) ON DELETE SET NULL;


--
-- Name: promocion_producto promocion_producto_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promocion_producto
    ADD CONSTRAINT promocion_producto_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.productos(id) ON DELETE CASCADE;


--
-- Name: promocion_producto promocion_producto_promocion_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promocion_producto
    ADD CONSTRAINT promocion_producto_promocion_id_foreign FOREIGN KEY (promocion_id) REFERENCES public.promociones(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict miEOhzflqnHjRKud1ehUoX8miVxwUldvNhFAblp4YbUgw7j34xxzJdhP02AUBFU

