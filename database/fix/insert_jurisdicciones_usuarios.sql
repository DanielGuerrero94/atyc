BEGIN;

DROP VIEW IF EXISTS
    alumnos.v_alumnos_excel;

DROP VIEW IF EXISTS
    pac.pac_joined;

ALTER TABLE
    sistema.provincias
ADD COLUMN IF NOT EXISTS
    abreviacion VARCHAR(255);

ALTER TABLE
    sistema.provincias
ALTER COLUMN
    nombre TYPE VARCHAR(255);

INSERT INTO
    sistema.provincias
        (nombre)
    VALUES
        ('Programa Sumar'),
        ('Programa Redes'),
        ('Programa Proteger'),
        ('Programa Telesalud'),
        ('Dirección Nacional de Gobernanza e Integración de los Sistemas de Salud'),
        ('Dirección Nacional de Innovación de la Gestión en Salud')
ON CONFLICT (nombre) DO NOTHING;

UPDATE
    sistema.provincias
SET
    nombre = 'Area Fortalecimiento Dirección Nacional de Fortalecimiento de los Sistemas Provinciales'
WHERE
    id_provincia = 25;

UPDATE
    sistema.provincias
SET
    abreviacion = 
    (
        CASE
            WHEN id_provincia = 1 THEN 'CABA'
            WHEN id_provincia = 2 THEN 'BA'
            WHEN id_provincia = 3 THEN 'CA'
            WHEN id_provincia = 4 THEN 'CB'
            WHEN id_provincia = 5 THEN 'CR'
            WHEN id_provincia = 6 THEN 'ER'
            WHEN id_provincia = 7 THEN 'JY'
            WHEN id_provincia = 8 THEN 'LR'
            WHEN id_provincia = 9 THEN 'MZ'
            WHEN id_provincia = 10 THEN 'SA'
            WHEN id_provincia = 11 THEN 'SJ'
            WHEN id_provincia = 12 THEN 'SL'
            WHEN id_provincia = 13 THEN 'SF'
            WHEN id_provincia = 14 THEN 'SE'
            WHEN id_provincia = 15 THEN 'TU'
            WHEN id_provincia = 16 THEN 'CH'
            WHEN id_provincia = 17 THEN 'CT'
            WHEN id_provincia = 18 THEN 'FO'
            WHEN id_provincia = 19 THEN 'LP'
            WHEN id_provincia = 20 THEN 'MI'
            WHEN id_provincia = 21 THEN 'NQ'
            WHEN id_provincia = 22 THEN 'RN'
            WHEN id_provincia = 23 THEN 'SC'
            WHEN id_provincia = 24 THEN 'TF'
            WHEN id_provincia = 25 THEN 'DNFSP'
            WHEN id_provincia = 26 THEN 'SUMAR'
            WHEN id_provincia = 27 THEN 'REDES'
            WHEN id_provincia = 28 THEN 'PROTEGER'
            WHEN id_provincia = 29 THEN 'TELESALUD'
            WHEN id_provincia = 30 THEN 'DNGISS'
            WHEN id_provincia = 31 THEN 'DNIGS'
        END
    );

INSERT INTO
    users
        (name, email, password, created_at, updated_at, id_provincia, title)
    SELECT
        CASE
            WHEN p.abreviacion = 'SUMAR' THEN 'sumar'
            WHEN p.abreviacion = 'REDES' THEN 'redes'
            WHEN p.abreviacion = 'PROTEGER' THEN 'proteger'
            WHEN p.abreviacion = 'TELESALUD' THEN 'telesalud'
            WHEN p.abreviacion = 'DNGISS' THEN 'dngiss'
            WHEN p.abreviacion = 'DNIGS' THEN 'dnigs'            
        END AS name,
        CASE
            WHEN p.abreviacion = 'SUMAR' THEN 'SUMAR@gmail.com'
            WHEN p.abreviacion = 'REDES' THEN 'REDES@gmail.com'
            WHEN p.abreviacion = 'PROTEGER' THEN 'PROTEGER@gmail.com'
            WHEN p.abreviacion = 'TELESALUD' THEN 'TELESALUD@gmail.com'
            WHEN p.abreviacion = 'DNGISS' THEN 'DNGISS@gmail.com'
            WHEN p.abreviacion = 'DNIGS' THEN 'DNIGS@gmail.com'            
        END AS email,
        CASE
            WHEN p.abreviacion = 'SUMAR' THEN '$2y$10$//hc0cv8LEZGHI8Yix.bBu1p5lgs2eEJ6Z8fLo.zjQ0Rtwb.icpf6'
            WHEN p.abreviacion = 'REDES' THEN '$2y$10$X.ZOODLuCxA5wLbWTtG2getcSTHBYhQHoggdlh3llzF4LFrhRVDY6'
            WHEN p.abreviacion = 'PROTEGER' THEN '$2y$10$VeOwGhHxHXFTXquivVyqq.PpE1zmkiKYCU5VglG2UAkrxDj7dA6ta'
            WHEN p.abreviacion = 'TELESALUD' THEN '$2y$10$6XSN/sNVfzw2h3WLKzYBquW8CK26obNnY/C6DqoV/aZ6wxfwz3qne'
            WHEN p.abreviacion = 'DNGISS' THEN '$2y$10$4DGTPbNi0OZpEWxof2TD6OQIuRWLxQWF5L6bNWIdxCO5iFuz/.TAu'
            WHEN p.abreviacion = 'DNIGS' THEN '$2y$10$wF9.RuEPpWsGY7fTUDYBMedA9PxQRaLP5iIk3uF5GOo.GrwKqtgOO'            
        END AS password,
        NOW() AS created_at,
        NOW() AS updated_at,
        p.id_provincia,
        CASE
            WHEN p.abreviacion = 'SUMAR' then 'Programa Sumar'
            WHEN p.abreviacion = 'REDES' THEN 'Programa Redes'
            WHEN p.abreviacion = 'PROTEGER' THEN 'Programa Proteger'
            WHEN p.abreviacion = 'TELESALUD' THEN 'Programa Telesalud'
            WHEN p.abreviacion = 'DNGISS' THEN 'Dirección Nacional de Gobernanza e Integración de los Sistemas de Salud'
            WHEN p.abreviacion = 'DNIGS' THEN 'Dirección Nacional de Innovación de la Gestión en Salud'            
        END AS title
    FROM
        sistema.provincias p
    WHERE
        p.abreviacion
    IN
        ('SUMAR', 'REDES', 'PROTEGER', 'TELESALUD', 'DNGISS', 'DNIGS')
ON CONFLICT (name) DO NOTHING;

UPDATE
    users
SET
    title = 'Área Fortalecimiento DNFSP'
WHERE
    id_user = 25;

ALTER TABLE
    users_roles
DROP CONSTRAINT IF EXISTS
    users_roles_id_user_id_role_unique;

ALTER TABLE
    users_roles
ADD CONSTRAINT
    users_roles_id_user_id_role_unique UNIQUE (id_user, id_role);

INSERT INTO
    users_roles
        (id_user, id_role)
    SELECT
        u.id_user,
        1 AS id_roles
    FROM
        users u
    WHERE
        u.name
    IN
        ('sumar', 'redes', 'proteger', 'telesalud', 'dngiss', 'dnigs')
ON CONFLICT ON CONSTRAINT users_roles_id_user_id_role_unique DO NOTHING;

CREATE VIEW alumnos.v_alumnos_excel AS
    SELECT 
        a.id_alumno,
        a.nombres,
        a.apellidos,
        t.id_tipo_documento,
        t.nombre AS tipo_documento,
        a.nro_doc,
        p.id_provincia,
        p.nombre AS provincia
    FROM alumnos.alumnos a
        JOIN sistema.provincias p ON p.id_provincia = a.id_provincia
        JOIN sistema.tipos_documentos t ON t.id_tipo_documento = a.id_tipo_documento
    WHERE a.deleted_at IS NULL;

CREATE VIEW pac.pac_joined AS
    SELECT
        p.id_pac,
        p.nombre,
        p.id_accion,
        p.ediciones,
        p.id_provincia,
        p.created_at,
        p.updated_at,
        p.deleted_at,
        p.duracion,
        p.id_ficha_tecnica,
        p.anio,
        p.ficha_obligatoria,
        c.fecha_plan_inicial AS fp_desde,
        c.fecha_plan_final AS fp_hasta,
        c.fecha_ejec_inicial AS fe_desde,
        c.fecha_ejec_final AS fe_hasta,
        le.numero AS linea_numero,
        le.nombre AS linea_nombre,
        ft.path AS ficha_tecnica_path,
        ft.original AS ficha_tecnica_original,
        ft.created_at AS ficha_tecnica_created_at,
        ft.updated_at AS ficha_tecnica_updated_at,
        ft.aprobada AS ficha_tecnica_aprobada,
        pro.nombre AS provincia,
        pt.id_tematica,
        pp.id_pauta,
        pr.id_responsable,
        pd.id_destinatario,
        pc.id_componente
    FROM pac.pacs p
        JOIN cursos.lineas_estrategicas le ON le.id_linea_estrategica = p.id_accion
        LEFT JOIN pac.fichas_tecnicas ft ON ft.id_ficha_tecnica = p.id_ficha_tecnica
        LEFT JOIN cursos.cursos c USING (id_pac)
        JOIN sistema.provincias pro ON pro.id_provincia = p.id_provincia
        LEFT JOIN pac.pacs_tematicas pt USING (id_pac)
        LEFT JOIN pac.pacs_pautas pp USING (id_pac)
        LEFT JOIN pac.pacs_responsables pr USING (id_pac)
        LEFT JOIN pac.pacs_destinatarios pd USING (id_pac)
        LEFT JOIN pac.pacs_componentes pc USING (id_pac);


COMMIT;