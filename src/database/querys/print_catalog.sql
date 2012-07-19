select * from standards_clusters_domains_grades, clusters_domains_grades, standards, clusters, domains_grades, domains, grades where clusters_domains_grades.id = standards_clusters_domains_grades.cluster_domain_grade_id and standards_clusters_domains_grades.standard_id = standards.id and clusters_domains_grades.cluster_id = clusters.id and clusters_domains_grades.domain_grade_id = domains_grades.id and domains_grades.domain_id = domains.id and domains_grades.grade_id = grades.id;


