/******************** BLOG *****************************/

/* TABLE DES POST DU BLOG */
CREATE TABLE blog_post(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    picture JSON DEFAULT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    content TEXT(650000) NOT NULL,
    created_at DATETIME NOT NULL,
    likes INT DEFAULT NULL,
    isLiked BOOLEAN NOT NULL,
    PRIMARY KEY (id)
)

/* TABLE DES CATEGORIE DU BLOG */
CREATE TABLE blog_category(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)

/* TABLE QUI SERT DE LIEN ENTRE "blog_post" et "blog_category" */
CREATE TABLE blog_post_category(
    post_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, category_id),
    CONSTRAINT fk_post
        FOREIGN KEY (post_id) 
        REFERENCES blog_post (id) /* On donne la table à lier et le nom du champs */
        ON DELETE CASCADE /* Permet de supprimer la ligne entière (le champs de la table) */
        ON UPDATE RESTRICT,/**/
    CONSTRAINT fk_category
        FOREIGN KEY (category_id)
        REFERENCES blog_category (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
)

/******************** ESPACE MEMBRE **************************/

/* TABLE UTILISATEUR */
CREATE TABLE user(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)