select * from standards_clusters_domains_grades, clusters_domains_grades, standards, clusters where clusters_domains_grades.id = standards_clusters_domains_grades.cluster_domain_grade_id and standards_clusters_domains_grades.standard_id = standards.id and clusters_domains_grades.cluster_id = clusters.id;

