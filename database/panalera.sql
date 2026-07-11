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

ALTER TABLE IF EXISTS ONLY public.promocion_producto DROP CONSTRAINT IF EXISTS promocion_producto_promocion_id_foreign;
ALTER TABLE IF EXISTS ONLY public.promocion_producto DROP CONSTRAINT IF EXISTS promocion_producto_producto_id_foreign;
ALTER TABLE IF EXISTS ONLY public.productos DROP CONSTRAINT IF EXISTS productos_marca_id_foreign;
ALTER TABLE IF EXISTS ONLY public.productos DROP CONSTRAINT IF EXISTS productos_etapa_id_foreign;
ALTER TABLE IF EXISTS ONLY public.productos DROP CONSTRAINT IF EXISTS productos_categoria_id_foreign;
ALTER TABLE IF EXISTS ONLY public.producto_imagens DROP CONSTRAINT IF EXISTS producto_imagens_producto_id_foreign;
ALTER TABLE IF EXISTS ONLY public.producto_atributos DROP CONSTRAINT IF EXISTS producto_atributos_producto_id_foreign;
ALTER TABLE IF EXISTS ONLY public.pedidos DROP CONSTRAINT IF EXISTS pedidos_user_id_foreign;
ALTER TABLE IF EXISTS ONLY public.pedido_items DROP CONSTRAINT IF EXISTS pedido_items_producto_id_foreign;
ALTER TABLE IF EXISTS ONLY public.pedido_items DROP CONSTRAINT IF EXISTS pedido_items_pedido_id_foreign;
ALTER TABLE IF EXISTS ONLY public.pedido_items DROP CONSTRAINT IF EXISTS pedido_items_atributo_id_foreign;
ALTER TABLE IF EXISTS ONLY public.cart_items DROP CONSTRAINT IF EXISTS cart_items_user_id_foreign;
ALTER TABLE IF EXISTS ONLY public.cart_items DROP CONSTRAINT IF EXISTS cart_items_producto_id_foreign;
DROP INDEX IF EXISTS public.sessions_user_id_index;
DROP INDEX IF EXISTS public.sessions_last_activity_index;
DROP INDEX IF EXISTS public.jobs_queue_index;
DROP INDEX IF EXISTS public.cache_locks_expiration_index;
DROP INDEX IF EXISTS public.cache_expiration_index;
ALTER TABLE IF EXISTS ONLY public.users DROP CONSTRAINT IF EXISTS users_pkey;
ALTER TABLE IF EXISTS ONLY public.users DROP CONSTRAINT IF EXISTS users_email_unique;
ALTER TABLE IF EXISTS ONLY public.sessions DROP CONSTRAINT IF EXISTS sessions_pkey;
ALTER TABLE IF EXISTS ONLY public.promociones DROP CONSTRAINT IF EXISTS promociones_pkey;
ALTER TABLE IF EXISTS ONLY public.promocion_producto DROP CONSTRAINT IF EXISTS promocion_producto_promocion_id_producto_id_unique;
ALTER TABLE IF EXISTS ONLY public.promocion_producto DROP CONSTRAINT IF EXISTS promocion_producto_pkey;
ALTER TABLE IF EXISTS ONLY public.productos DROP CONSTRAINT IF EXISTS productos_pkey;
ALTER TABLE IF EXISTS ONLY public.producto_imagens DROP CONSTRAINT IF EXISTS producto_imagens_pkey;
ALTER TABLE IF EXISTS ONLY public.producto_atributos DROP CONSTRAINT IF EXISTS producto_atributos_pkey;
ALTER TABLE IF EXISTS ONLY public.pedidos DROP CONSTRAINT IF EXISTS pedidos_token_unique;
ALTER TABLE IF EXISTS ONLY public.pedidos DROP CONSTRAINT IF EXISTS pedidos_pkey;
ALTER TABLE IF EXISTS ONLY public.pedidos DROP CONSTRAINT IF EXISTS pedidos_mp_preference_id_unique;
ALTER TABLE IF EXISTS ONLY public.pedido_items DROP CONSTRAINT IF EXISTS pedido_items_pkey;
ALTER TABLE IF EXISTS ONLY public.password_reset_tokens DROP CONSTRAINT IF EXISTS password_reset_tokens_pkey;
ALTER TABLE IF EXISTS ONLY public.migrations DROP CONSTRAINT IF EXISTS migrations_pkey;
ALTER TABLE IF EXISTS ONLY public.marcas DROP CONSTRAINT IF EXISTS marcas_pkey;
ALTER TABLE IF EXISTS ONLY public.jobs DROP CONSTRAINT IF EXISTS jobs_pkey;
ALTER TABLE IF EXISTS ONLY public.job_batches DROP CONSTRAINT IF EXISTS job_batches_pkey;
ALTER TABLE IF EXISTS ONLY public.failed_jobs DROP CONSTRAINT IF EXISTS failed_jobs_uuid_unique;
ALTER TABLE IF EXISTS ONLY public.failed_jobs DROP CONSTRAINT IF EXISTS failed_jobs_pkey;
ALTER TABLE IF EXISTS ONLY public.etapas DROP CONSTRAINT IF EXISTS etapas_pkey;
ALTER TABLE IF EXISTS ONLY public.configuraciones DROP CONSTRAINT IF EXISTS configuraciones_pkey;
ALTER TABLE IF EXISTS ONLY public.categorias DROP CONSTRAINT IF EXISTS categorias_pkey;
ALTER TABLE IF EXISTS ONLY public.cart_items DROP CONSTRAINT IF EXISTS cart_items_user_id_producto_id_atributo_id_unique;
ALTER TABLE IF EXISTS ONLY public.cart_items DROP CONSTRAINT IF EXISTS cart_items_pkey;
ALTER TABLE IF EXISTS ONLY public.cache DROP CONSTRAINT IF EXISTS cache_pkey;
ALTER TABLE IF EXISTS ONLY public.cache_locks DROP CONSTRAINT IF EXISTS cache_locks_pkey;
ALTER TABLE IF EXISTS public.users ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.promociones ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.promocion_producto ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.productos ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.producto_imagens ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.producto_atributos ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.pedidos ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.pedido_items ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.migrations ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.marcas ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.jobs ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.failed_jobs ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.etapas ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.configuraciones ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.categorias ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.cart_items ALTER COLUMN id DROP DEFAULT;
DROP SEQUENCE IF EXISTS public.users_id_seq;
DROP TABLE IF EXISTS public.users;
DROP TABLE IF EXISTS public.sessions;
DROP SEQUENCE IF EXISTS public.promociones_id_seq;
DROP TABLE IF EXISTS public.promociones;
DROP SEQUENCE IF EXISTS public.promocion_producto_id_seq;
DROP TABLE IF EXISTS public.promocion_producto;
DROP SEQUENCE IF EXISTS public.productos_id_seq;
DROP TABLE IF EXISTS public.productos;
DROP SEQUENCE IF EXISTS public.producto_imagens_id_seq;
DROP TABLE IF EXISTS public.producto_imagens;
DROP SEQUENCE IF EXISTS public.producto_atributos_id_seq;
DROP TABLE IF EXISTS public.producto_atributos;
DROP SEQUENCE IF EXISTS public.pedidos_id_seq;
DROP TABLE IF EXISTS public.pedidos;
DROP SEQUENCE IF EXISTS public.pedido_items_id_seq;
DROP TABLE IF EXISTS public.pedido_items;
DROP TABLE IF EXISTS public.password_reset_tokens;
DROP SEQUENCE IF EXISTS public.migrations_id_seq;
DROP TABLE IF EXISTS public.migrations;
DROP SEQUENCE IF EXISTS public.marcas_id_seq;
DROP TABLE IF EXISTS public.marcas;
DROP SEQUENCE IF EXISTS public.jobs_id_seq;
DROP TABLE IF EXISTS public.jobs;
DROP TABLE IF EXISTS public.job_batches;
DROP SEQUENCE IF EXISTS public.failed_jobs_id_seq;
DROP TABLE IF EXISTS public.failed_jobs;
DROP SEQUENCE IF EXISTS public.etapas_id_seq;
DROP TABLE IF EXISTS public.etapas;
DROP SEQUENCE IF EXISTS public.configuraciones_id_seq;
DROP TABLE IF EXISTS public.configuraciones;
DROP SEQUENCE IF EXISTS public.categorias_id_seq;
DROP TABLE IF EXISTS public.categorias;
DROP SEQUENCE IF EXISTS public.cart_items_id_seq;
DROP TABLE IF EXISTS public.cart_items;
DROP TABLE IF EXISTS public.cache_locks;
DROP TABLE IF EXISTS public.cache;
SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


--
-- Name: cart_items; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cart_items (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    producto_id bigint NOT NULL,
    cantidad integer DEFAULT 1 NOT NULL,
    atributo_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: cart_items_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.cart_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: cart_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.cart_items_id_seq OWNED BY public.cart_items.id;


--
-- Name: categorias; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.categorias (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    activo boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: categorias_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.categorias_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: categorias_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.categorias_id_seq OWNED BY public.categorias.id;


--
-- Name: configuraciones; Type: TABLE; Schema: public; Owner: -
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


--
-- Name: configuraciones_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.configuraciones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: configuraciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.configuraciones_id_seq OWNED BY public.configuraciones.id;


--
-- Name: etapas; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.etapas (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    activo boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: etapas_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.etapas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: etapas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.etapas_id_seq OWNED BY public.etapas.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: -
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


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: -
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


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: -
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


--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: marcas; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.marcas (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    activo boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    imagen character varying(255)
);


--
-- Name: marcas_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.marcas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: marcas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.marcas_id_seq OWNED BY public.marcas.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


--
-- Name: pedido_items; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.pedido_items (
    id bigint NOT NULL,
    pedido_id bigint NOT NULL,
    producto_id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    cantidad integer NOT NULL,
    precio_unitario numeric(10,2) NOT NULL,
    subtotal numeric(10,2) NOT NULL,
    atributo_info character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    atributo_id bigint
);


--
-- Name: pedido_items_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.pedido_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: pedido_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.pedido_items_id_seq OWNED BY public.pedido_items.id;


--
-- Name: pedidos; Type: TABLE; Schema: public; Owner: -
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
    email character varying(255)
);


--
-- Name: pedidos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.pedidos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: pedidos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.pedidos_id_seq OWNED BY public.pedidos.id;


--
-- Name: producto_atributos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.producto_atributos (
    id bigint NOT NULL,
    producto_id bigint NOT NULL,
    tipo character varying(255) NOT NULL,
    valor character varying(255) NOT NULL,
    precio_adicional numeric(10,2) DEFAULT '0'::numeric NOT NULL,
    stock integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: producto_atributos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.producto_atributos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: producto_atributos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.producto_atributos_id_seq OWNED BY public.producto_atributos.id;


--
-- Name: producto_imagens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.producto_imagens (
    id bigint NOT NULL,
    producto_id bigint NOT NULL,
    path character varying(255) NOT NULL,
    es_principal boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: producto_imagens_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.producto_imagens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: producto_imagens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.producto_imagens_id_seq OWNED BY public.producto_imagens.id;


--
-- Name: productos; Type: TABLE; Schema: public; Owner: -
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


--
-- Name: productos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.productos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: productos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.productos_id_seq OWNED BY public.productos.id;


--
-- Name: promocion_producto; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.promocion_producto (
    id bigint NOT NULL,
    promocion_id bigint NOT NULL,
    producto_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: promocion_producto_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.promocion_producto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: promocion_producto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.promocion_producto_id_seq OWNED BY public.promocion_producto.id;


--
-- Name: promociones; Type: TABLE; Schema: public; Owner: -
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


--
-- Name: promociones_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.promociones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: promociones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.promociones_id_seq OWNED BY public.promociones.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
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


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: cart_items id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cart_items ALTER COLUMN id SET DEFAULT nextval('public.cart_items_id_seq'::regclass);


--
-- Name: categorias id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.categorias ALTER COLUMN id SET DEFAULT nextval('public.categorias_id_seq'::regclass);


--
-- Name: configuraciones id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.configuraciones ALTER COLUMN id SET DEFAULT nextval('public.configuraciones_id_seq'::regclass);


--
-- Name: etapas id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.etapas ALTER COLUMN id SET DEFAULT nextval('public.etapas_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: marcas id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.marcas ALTER COLUMN id SET DEFAULT nextval('public.marcas_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: pedido_items id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedido_items ALTER COLUMN id SET DEFAULT nextval('public.pedido_items_id_seq'::regclass);


--
-- Name: pedidos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedidos ALTER COLUMN id SET DEFAULT nextval('public.pedidos_id_seq'::regclass);


--
-- Name: producto_atributos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.producto_atributos ALTER COLUMN id SET DEFAULT nextval('public.producto_atributos_id_seq'::regclass);


--
-- Name: producto_imagens id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.producto_imagens ALTER COLUMN id SET DEFAULT nextval('public.producto_imagens_id_seq'::regclass);


--
-- Name: productos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.productos ALTER COLUMN id SET DEFAULT nextval('public.productos_id_seq'::regclass);


--
-- Name: promocion_producto id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.promocion_producto ALTER COLUMN id SET DEFAULT nextval('public.promocion_producto_id_seq'::regclass);


--
-- Name: promociones id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.promociones ALTER COLUMN id SET DEFAULT nextval('public.promociones_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cache (key, value, expiration) FROM stdin;
laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer	i:1783781830;	1783781830
laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6	i:1;	1783781830
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: cart_items; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cart_items (id, user_id, producto_id, cantidad, atributo_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: categorias; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.categorias (id, nombre, activo, created_at, updated_at) FROM stdin;
1	Pañales	t	2026-07-06 20:45:02	2026-07-06 20:45:02
2	Ropa	t	2026-07-06 20:45:02	2026-07-06 20:45:02
3	Higiene	t	2026-07-06 20:45:02	2026-07-06 20:45:02
4	Alimentación	t	2026-07-06 20:45:02	2026-07-06 20:45:02
5	Accesorios	t	2026-07-06 20:45:02	2026-07-06 20:45:02
\.


--
-- Data for Name: configuraciones; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.configuraciones (id, nombre_negocio, descripcion, direccion, telefono, email, whatsapp, instagram, facebook, horarios, created_at, updated_at) FROM stdin;
1	Adolfina	Tu tienda de confianza para el cuidado de tu bebé. Pañales, ropa, higiene y más.	\N	\N	contacto@panalera.com	541112345678	https://www.google.com	https://www.google.com	de 8 a 21	2026-07-06 20:45:02	2026-07-07 00:23:43
\.


--
-- Data for Name: etapas; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.etapas (id, nombre, activo, created_at, updated_at) FROM stdin;
9	Adulto	t	2026-07-09 18:54:14	2026-07-09 18:54:14
8	Niño	t	2026-07-09 18:54:01	2026-07-09 18:54:35
7	Bebé	t	2026-07-09 18:53:51	2026-07-09 18:54:41
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: marcas; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.marcas (id, nombre, activo, created_at, updated_at, imagen) FROM stdin;
1	Huggies	t	2026-07-06 20:45:02	2026-07-09 16:31:59	marcas/01KX3VHH2MJV4B40HJ5CRBFBRR.jpg
2	Pampers	t	2026-07-06 20:45:02	2026-07-09 16:53:06	marcas/01KX3WR76NH2DA7HHNY5AEGAT1.jpg
3	Babysec	t	2026-07-06 20:45:02	2026-07-09 17:01:11	marcas/01KX3X70CVCM5N90XEYFA6YDZ8.jpg
4	Pequeño Mundo	t	2026-07-06 20:45:02	2026-07-09 17:18:50	marcas/01KX3Y7A5PVWWT9022WXTS3NP3.jpg
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
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
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: pedido_items; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.pedido_items (id, pedido_id, producto_id, nombre, cantidad, precio_unitario, subtotal, atributo_info, created_at, updated_at, atributo_id) FROM stdin;
\.


--
-- Data for Name: pedidos; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.pedidos (id, user_id, total, subtotal, descuento, estado, direccion, ciudad, codigo_postal, telefono, observaciones, mp_preference_id, mp_payment_id, mp_status, mp_merchant_order_id, created_at, updated_at, token, email) FROM stdin;
\.


--
-- Data for Name: producto_atributos; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.producto_atributos (id, producto_id, tipo, valor, precio_adicional, stock, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: producto_imagens; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.producto_imagens (id, producto_id, path, es_principal, created_at, updated_at) FROM stdin;
1	1	productos/01KX3X92G03CG080CKZ75M0K7A.jpeg	t	2026-07-09 17:02:19	2026-07-09 17:02:19
3	1	productos/01KX3XBSCPKFWDQVZZGFJNJGNK.jpeg	f	2026-07-09 17:03:48	2026-07-09 17:03:48
4	1	productos/01KX3XDK6TVV4YW88ZWAV28GV2.jpeg	f	2026-07-09 17:04:47	2026-07-09 17:04:47
\.


--
-- Data for Name: productos; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.productos (id, categoria_id, nombre, descripcion, precio, stock, edad_talla, activo, destacado, created_at, updated_at, marca_id, etapa_id, tiene_talla) FROM stdin;
1	1	Pañales Huggies Supreme RN x50	<p>Pañales descartables Huggies Supreme para recién nacido. Suaves y con protección total.</p>	8500.00	100	RN (2-5 kg)	t	t	2026-07-06 20:45:02	2026-07-09 17:03:52	1	\N	f
2	1	Pañales Pampers Premium Care M x48	Pañales Pampers Premium Care, talla mediana. Máxima absorción y sequedad.	9200.00	80	M (6-11 kg)	t	t	2026-07-06 20:45:02	2026-07-06 21:38:06	2	\N	f
4	2	Body manga corta x3	Pack de 3 bodies de algodón manga corta, ideal para el día a día.	5500.00	40	RN - 12 meses	t	t	2026-07-06 20:45:02	2026-07-06 21:38:06	4	\N	f
9	4	Papilla Nestum Multicereal 200g	Papilla de multicereal fortificada con vitaminas y minerales.	3200.00	90	6+ meses	t	f	2026-07-06 20:45:02	2026-07-06 21:38:06	\N	\N	f
3	1	Pañales Babysec G x42	<p>Pañales Babysec talla grande, con barreras anti-filtraje y ajuste elástico.</p>	7800.00	60	G (9-14 kg)	t	f	2026-07-06 20:45:02	2026-07-06 21:44:45	3	\N	f
13	1	Pañales Babysec G x42	Pañales Babysec talla grande, con barreras anti-filtraje y ajuste elástico.	7800.00	60	G (9-14 kg)	t	f	2026-07-06 20:51:22	2026-07-06 21:38:02	3	\N	f
5	2	Enterito polar con capucha	Enterito de polar suave con capucha, perfecto para el invierno.	9800.00	30	6-18 meses	t	f	2026-07-06 20:45:02	2026-07-06 21:38:06	4	\N	f
11	1	Pañales Huggies Supreme RN x50	Pañales descartables Huggies Supreme para recién nacido. Suaves y con protección total.	8500.00	100	RN (2-5 kg)	t	t	2026-07-06 20:51:22	2026-07-06 21:38:06	1	\N	f
12	1	Pañales Pampers Premium Care M x48	Pañales Pampers Premium Care, talla mediana. Máxima absorción y sequedad.	9200.00	80	M (6-11 kg)	t	t	2026-07-06 20:51:22	2026-07-06 21:38:06	2	\N	f
14	2	Body manga corta x3	Pack de 3 bodies de algodón manga corta, ideal para el día a día.	5500.00	40	RN - 12 meses	t	t	2026-07-06 20:51:23	2026-07-06 21:38:06	4	\N	f
15	2	Enterito polar con capucha	Enterito de polar suave con capucha, perfecto para el invierno.	9800.00	30	6-18 meses	t	f	2026-07-06 20:51:23	2026-07-06 21:38:06	4	\N	f
19	4	Papilla Nestum Multicereal 200g	Papilla de multicereal fortificada con vitaminas y minerales.	3200.00	90	6+ meses	t	f	2026-07-06 20:51:23	2026-07-06 21:38:06	\N	\N	f
8	4	Leche NAN 1 polvo 800g	Leche en polvo para lactantes desde el primer día.	14500.00	40	0-6 meses	t	t	2026-07-06 20:45:02	2026-07-06 21:38:06	\N	\N	f
18	4	Leche NAN 1 polvo 800g	Leche en polvo para lactantes desde el primer día.	14500.00	40	0-6 meses	t	t	2026-07-06 20:51:23	2026-07-06 21:38:06	\N	\N	f
10	5	Chupete ortodóntico silicona 0-6m x2	Chupete de silicona ortodóntico con protector nasal. Pack x2.	2800.00	100	\N	t	f	2026-07-06 20:45:02	2026-07-06 21:38:06	\N	\N	f
20	5	Chupete ortodóntico silicona 0-6m x2	Chupete de silicona ortodóntico con protector nasal. Pack x2.	2800.00	100	\N	t	f	2026-07-06 20:51:23	2026-07-06 21:38:06	\N	\N	f
6	3	Crema para pañal Mustela 100ml	Crema protectora para la zona del pañal, previene y trata la irritación.	6200.00	50	\N	t	t	2026-07-06 20:45:02	2026-07-06 21:38:06	\N	\N	f
16	3	Crema para pañal Mustela 100ml	Crema protectora para la zona del pañal, previene y trata la irritación.	6200.00	50	\N	t	t	2026-07-06 20:51:23	2026-07-06 21:38:06	\N	\N	f
7	3	Shampoo + jabón líquido Johnson Baby 500ml	Shampoo y jabón 2 en 1, fórmula suave sin lágrimas.	4100.00	70	\N	t	f	2026-07-06 20:45:02	2026-07-06 21:38:06	\N	\N	f
17	3	Shampoo + jabón líquido Johnson Baby 500ml	Shampoo y jabón 2 en 1, fórmula suave sin lágrimas.	4100.00	70	\N	t	f	2026-07-06 20:51:23	2026-07-06 21:38:06	\N	\N	f
\.


--
-- Data for Name: promocion_producto; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.promocion_producto (id, promocion_id, producto_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: promociones; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.promociones (id, nombre, descripcion, tipo_descuento, valor_descuento, fecha_inicio, fecha_fin, activo, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
3VZGKfdfCdL62g0KCPlNxQBeDDy0Jx8tBMrbpfqx	1	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36	YTo4OntzOjY6Il90b2tlbiI7czo0MDoiV0tYOFVVSFBWR1RmYUJZZmFyM09QbFBsdXJDNlNuellmb3lNSmx5NyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvcHJvZHVjdG9zLzgvcHJlY2lvIjtzOjU6InJvdXRlIjtzOjIwOiJhcGkucHJvZHVjdG9zLnByZWNpbyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiIyNDNmNGIzNTI0YTU1M2IxNTdlZjJhMWEwYTFlM2IyZWM0YWM5Nzk3MTVlMjRkZDc5MWI4NzMzNDZlODEzYzY5IjtzOjY6InRhYmxlcyI7YTozOntzOjQwOiIwODc4MTM3NzQ0NzI1NTc5YWMxMzZhODFkMTNlNDExY19jb2x1bW5zIjthOjM6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJpbWFnZW4iO3M6NToibGFiZWwiO3M6NjoiSW1hZ2VuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJub21icmUiO3M6NToibGFiZWwiO3M6NjoiTm9tYnJlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJhY3Rpdm8iO3M6NToibGFiZWwiO3M6NjoiQWN0aXZvIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiIxMTdmNTFjN2JjYTRhMzRjZWZkMmJjOTdmOWE2NTkxOF9jb2x1bW5zIjthOjg6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJub21icmUiO3M6NToibGFiZWwiO3M6NjoiTm9tYnJlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNjoiY2F0ZWdvcmlhLm5vbWJyZSI7czo1OiJsYWJlbCI7czoxMDoiQ2F0ZWdvcsOtYSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTI6Im1hcmNhLm5vbWJyZSI7czo1OiJsYWJlbCI7czo1OiJNYXJjYSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTI6ImV0YXBhLm5vbWJyZSI7czo1OiJsYWJlbCI7czo1OiJFdGFwYSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NjoicHJlY2lvIjtzOjU6ImxhYmVsIjtzOjY6IlByZWNpbyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToic3RvY2siO3M6NToibGFiZWwiO3M6NToiU3RvY2siO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6ImFjdGl2byI7czo1OiJsYWJlbCI7czo2OiJBY3Rpdm8iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo3O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6ImRlc3RhY2FkbyI7czo1OiJsYWJlbCI7czo5OiJEZXN0YWNhZG8iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6IjMyM2Y2MDU5Y2FkMDRiNmEyNDg3YzQzYWMzODg3NDRjX2NvbHVtbnMiO2E6Mjp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6Im5vbWJyZSI7czo1OiJsYWJlbCI7czo2OiJOb21icmUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6ImFjdGl2byI7czo1OiJsYWJlbCI7czo2OiJBY3Rpdm8iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fX1zOjg6ImZpbGFtZW50IjthOjA6e319	1783783900
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, direccion, telefono, is_admin) FROM stdin;
1	Admin	admin@panalera.com	\N	$2y$12$9rTKSF53ZKhIDaOI1EDipeIA2RjQO0YVn.kawIIfLBCIBOlch3Y7q	\N	2026-07-06 20:45:02	2026-07-06 20:51:33	\N	\N	t
2	cristian	cristian@gmail.com	\N	$2y$12$kb9pcl79LhfFwd.50eAsUejm2OodPZHeMTzt/o.s50iIurESJc/4a	\N	2026-07-06 22:13:48	2026-07-06 22:13:48	\N	\N	f
4	sergio	sergio@gmail.com	\N	$2y$12$PdYiCwSJ7pd3GeYupECr7OMXc4iyjsbUNbR9rrO5DjV.yXnybbsuS	\N	2026-07-08 22:46:09	2026-07-08 22:46:09	\N	\N	f
\.


--
-- Name: cart_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.cart_items_id_seq', 18, true);


--
-- Name: categorias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.categorias_id_seq', 20, true);


--
-- Name: configuraciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.configuraciones_id_seq', 1, true);


--
-- Name: etapas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.etapas_id_seq', 9, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: marcas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.marcas_id_seq', 17, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.migrations_id_seq', 31, true);


--
-- Name: pedido_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.pedido_items_id_seq', 27, true);


--
-- Name: pedidos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.pedidos_id_seq', 20, true);


--
-- Name: producto_atributos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.producto_atributos_id_seq', 1, false);


--
-- Name: producto_imagens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.producto_imagens_id_seq', 4, true);


--
-- Name: productos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.productos_id_seq', 22, true);


--
-- Name: promocion_producto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.promocion_producto_id_seq', 4, true);


--
-- Name: promociones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.promociones_id_seq', 3, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.users_id_seq', 4, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: cart_items cart_items_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cart_items
    ADD CONSTRAINT cart_items_pkey PRIMARY KEY (id);


--
-- Name: cart_items cart_items_user_id_producto_id_atributo_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cart_items
    ADD CONSTRAINT cart_items_user_id_producto_id_atributo_id_unique UNIQUE (user_id, producto_id, atributo_id);


--
-- Name: categorias categorias_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_pkey PRIMARY KEY (id);


--
-- Name: configuraciones configuraciones_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.configuraciones
    ADD CONSTRAINT configuraciones_pkey PRIMARY KEY (id);


--
-- Name: etapas etapas_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.etapas
    ADD CONSTRAINT etapas_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: marcas marcas_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.marcas
    ADD CONSTRAINT marcas_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: pedido_items pedido_items_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedido_items
    ADD CONSTRAINT pedido_items_pkey PRIMARY KEY (id);


--
-- Name: pedidos pedidos_mp_preference_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_mp_preference_id_unique UNIQUE (mp_preference_id);


--
-- Name: pedidos pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id);


--
-- Name: pedidos pedidos_token_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_token_unique UNIQUE (token);


--
-- Name: producto_atributos producto_atributos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.producto_atributos
    ADD CONSTRAINT producto_atributos_pkey PRIMARY KEY (id);


--
-- Name: producto_imagens producto_imagens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.producto_imagens
    ADD CONSTRAINT producto_imagens_pkey PRIMARY KEY (id);


--
-- Name: productos productos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_pkey PRIMARY KEY (id);


--
-- Name: promocion_producto promocion_producto_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.promocion_producto
    ADD CONSTRAINT promocion_producto_pkey PRIMARY KEY (id);


--
-- Name: promocion_producto promocion_producto_promocion_id_producto_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.promocion_producto
    ADD CONSTRAINT promocion_producto_promocion_id_producto_id_unique UNIQUE (promocion_id, producto_id);


--
-- Name: promociones promociones_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.promociones
    ADD CONSTRAINT promociones_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: cart_items cart_items_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cart_items
    ADD CONSTRAINT cart_items_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.productos(id) ON DELETE CASCADE;


--
-- Name: cart_items cart_items_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cart_items
    ADD CONSTRAINT cart_items_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: pedido_items pedido_items_atributo_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedido_items
    ADD CONSTRAINT pedido_items_atributo_id_foreign FOREIGN KEY (atributo_id) REFERENCES public.producto_atributos(id) ON DELETE SET NULL;


--
-- Name: pedido_items pedido_items_pedido_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedido_items
    ADD CONSTRAINT pedido_items_pedido_id_foreign FOREIGN KEY (pedido_id) REFERENCES public.pedidos(id) ON DELETE CASCADE;


--
-- Name: pedido_items pedido_items_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedido_items
    ADD CONSTRAINT pedido_items_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.productos(id) ON DELETE CASCADE;


--
-- Name: pedidos pedidos_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: producto_atributos producto_atributos_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.producto_atributos
    ADD CONSTRAINT producto_atributos_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.productos(id) ON DELETE CASCADE;


--
-- Name: producto_imagens producto_imagens_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.producto_imagens
    ADD CONSTRAINT producto_imagens_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.productos(id) ON DELETE CASCADE;


--
-- Name: productos productos_categoria_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_categoria_id_foreign FOREIGN KEY (categoria_id) REFERENCES public.categorias(id) ON DELETE CASCADE;


--
-- Name: productos productos_etapa_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_etapa_id_foreign FOREIGN KEY (etapa_id) REFERENCES public.etapas(id) ON DELETE SET NULL;


--
-- Name: productos productos_marca_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_marca_id_foreign FOREIGN KEY (marca_id) REFERENCES public.marcas(id) ON DELETE SET NULL;


--
-- Name: promocion_producto promocion_producto_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.promocion_producto
    ADD CONSTRAINT promocion_producto_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.productos(id) ON DELETE CASCADE;


--
-- Name: promocion_producto promocion_producto_promocion_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.promocion_producto
    ADD CONSTRAINT promocion_producto_promocion_id_foreign FOREIGN KEY (promocion_id) REFERENCES public.promociones(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict TUvhS3tLsSdtReBow6tT750MmC2KnMde1IdfnI4lje8FxaP684fyMe23tm6SFLD

